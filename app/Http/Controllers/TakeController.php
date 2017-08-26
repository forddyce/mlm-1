<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TakeRepository;
use Yajra\Datatables\Datatables;

class TakeController extends Controller
{
    /**
     * The TakeRepository instance.
     *
     * @var \App\Repositories\TakeRepository
     */
    protected $TakeRepository;

    /**
     * Create a new TakeController instance.
     *
     * @param \App\Repositories\TakeRepository $TakeRepository
     * @return void
     */
    public function __construct(TakeRepository $TakeRepository) {
        $this->TakeRepository = $TakeRepository;
        $this->middleware('member', ['only' => ['postWithdrawWallet', 'postMemberUpdate', 'postWithdrawRoiWallet']]);
        $this->middleware('admin', ['only' => 'postAdminUpdate', 'destroy']);
    }

    public function index (Datatables $datatables) {
        return $this->TakeRepository->search($datatables);
    }

    public function count () {
        $total = $this->TakeRepository->getTotal('status', 'waiting-admin');
        return \Response::json([
            'type'  =>  'success',
            'total' =>  $total
        ]);
    }

    public function show ($id) {
        if (!$model = $this->TakeRepository->findById(trim($id))) {
            return 'Withdraw not found.';
        }
        return view('back.withdraw.detail')->with('model', $model);
    }

    public function postWithdrawWallet () {
        $user = \Sentinel::getUser();
        $member = $user->member;

        if ($member->bank_name == '' || 
            $member->bank_account_number == '' || 
            $member->bank_account_holder == '' || 
            $member->identification_number == ''
        ) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.bankInfoError')
            ]);
        }

        $data = \Input::get('data');
        $amount = (float) trim($data['amount']);
        if ($amount % 100 != 0) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.divisibleError')
            ]);
        }

        if ($check = $this->TakeRepository->checkUser($member)) {
            return \Response::json([
                'type'  =>  'warning',
                'message'   =>  \Lang::get('error.withdrawError')
            ]);
        }

        $cash = (float) $member->cash_wallet;
        $roi = (float) $member->roi_wallet; 

        if ($cash < $amount) {
            $left = $amount - $cash;
            if ($roi < $left) {
                return \Response::json([
                    'type'  =>  'warning',
                    'message'   =>  \Lang::get('error.withdrawWalletError')
                ]);
            }
            $member->cash_wallet = 0;
            $member->roi_wallet -= $left;
            if ($member->roi_wallet < 0) $member->roi_wallet = 0;
        } else {
            $member->cash_wallet -= $amount;
        }

        $this->TakeRepository->store([
            'member_id' =>  $member->id,
            'amount'    =>  $amount,
            'type'  =>  'cash',
            'status'    =>  'waiting-admin'
        ]);

        $member->save();
        \Cache::forget('member.' . $member->id);

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  \Lang::get('message.withdrawSuccess'),
            'redirect'  =>  route('transaction.statement', ['lang' => \App::getLocale()])
        ]);
    }

    // public function postWithdrawRoiWallet () {
    //     $user = \Sentinel::getUser();
    //     $member = $user->member;

    //     if ($member->bank_name == '' || 
    //         $member->bank_account_number == '' || 
    //         $member->bank_account_holder == '' || 
    //         $member->identification_number == ''
    //     ) {
    //         return \Response::json([
    //             'type'  =>  'error',
    //             'message'   =>  'One of bank information is still empty.'
    //         ]);
    //     }

    //     $data = \Input::get('data');
    //     $amount = (float) trim($data['amount']);
    //     if ($amount % 50 != 0) {
    //         return \Response::json([
    //             'type'  =>  'error',
    //             'message'   =>  'Amount must be divisible by 50.'
    //         ]);
    //     }

    //     if ((float) $member->roi_wallet < $amount) {
    //         return \Response::json([
    //             'type'  =>  'error',
    //             'message'   =>  'You do not have enough roi wallet.'
    //         ]);
    //     }

    //     if ($check = $this->TakeRepository->checkUser($member)) {
    //         return \Response::json([
    //             'type'  =>  'warning',
    //             'message'   =>  'You still have a batch of withdraw (ID #' . $check->id . ') that is not done yet.'
    //         ]);
    //     }

    //     $this->TakeRepository->store([
    //         'member_id' =>  $member->id,
    //         'amount'    =>  $amount,
    //         'type'  =>  'roi',
    //         'status'    =>  'waiting-admin'
    //     ]);

    //     $member->roi_wallet -= $amount;
    //     $member->save();
    //     \Cache::forget('member.' . $member->id);

    //     return \Response::json([
    //         'type'  =>  'success',
    //         'message'   =>  'Withdraw created successfully.',
    //         'redirect'  =>  route('transaction.statement')
    //     ]);
    // }

    public function postMemberUpdate () {
        $id = trim(\Input::get('id'));
        if (!$model = $this->TakeRepository->findById($id)) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  'Withdraw not found.'
            ]);
        }
        $model->status = 'waiting-admin';
        $model->save();

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  'Withdraw #' . $model->id . ' confirmed.'
        ]);
    }

    public function postAdminUpdate () {
        $id = trim(\Input::get('id'));
        if (!$model = $this->TakeRepository->findById($id)) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  'Withdraw not found.'
            ]);
        }

        $status = \Input::get('status');
        if ($status != 'done' && $status != 'reject') {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  'Status data error.'
            ]);
        }
        $model->status = trim($status);
        $model->save();

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  'Withdraw #' . $model->id . ' updated.'
        ]);
    }

    public function destroy ($id) {
        if (!$model = $this->TakeRepository->findById(trim($id))) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  'Withdraw #' . $id . ' not found.'
            ]);
        }

        $model->delete();

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  'Withdraw #' . $id . ' removed.'
        ]);
    }
}
