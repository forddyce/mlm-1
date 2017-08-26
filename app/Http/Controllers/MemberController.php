<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MemberRepository;
use App\Repositories\PackageRepository;
use App\Repositories\BonusRepository;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class MemberController extends Controller
{
    /**
     * The MemberRepository instance.
     *
     * @var \App\Repositories\MemberRepository
     */
    protected $MemberRepository;

    /**
     * The PackageRepository instance.
     *
     * @var \App\Repositories\PackageRepository
     */
    protected $PackageRepository;

    /**
     * The BonusRepository instance.
     *
     * @var \App\Repositories\PackageRepository
     */
    protected $BonusRepository;

    /**
     * Create a new MemberController instance.
     *
     * @param \App\Repositories\MemberRepository $MemberRepository
     * @return void
     */
    public function __construct(
        MemberRepository $MemberRepository,
        PackageRepository $PackageRepository,
        BonusRepository $BonusRepository
    ) {
        $this->middleware('member', ['except' => [
                'postLogin'
            ]
        ]);
        $this->MemberRepository = $MemberRepository;
        $this->PackageRepository = $PackageRepository;
        $this->BonusRepository = $BonusRepository;
    }

    public function store () {
        $data = \Input::get('data');

        if (!$package = $this->PackageRepository->findById(trim($data['package_id']))) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.packageNotFound')
            ]);
        }

        $currentUser = \Sentinel::getUser();
        $currentMember = $currentUser->member;

        if ($currentMember->register_wallet < $package->package_amount) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>   \Lang::get('error.registerCoinNotEnough')
            ]); 
        }

        if (!$parent = $this->MemberRepository->findByUsername(trim($data['upline_id']))) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.uplineNotFound')
            ]); 
        }

        $today = Carbon::now();
        $newData = [];
        $newData['package_id'] = $package->id;
        $newData['package_amount'] = $package->package_amount;
        $newData['direct'] = $package->direct;
        $newData['roi'] = $package->roi;
        $newData['next_roi'] = $today->addDays(7);
        $newData['max_profit'] = $package->max_profit;
        $allowed = $this->MemberRepository->getAllowedFields();

        foreach ($data as $k => $d) {
            if (in_array($k, $allowed)) {
                if ($d == '') $d = null;
                $newData[$k] = trim($d);
            }
        }

        try {
            if (\Sentinel::findByCredentials([
                'login' =>  $data['username']
            ])) {
                throw new \Exception(\Lang::get('error.usernameExists'));
                return false;
            }
            $user = \Sentinel::registerAndActivate([
                'email'   => $data['email'],
                'username'  =>  $data['username'],
                'password'  =>  $data['password'],
                'permissions' =>  [
                    'user' => true,
                ]
            ]);
        } catch (\Exception $e) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  $e->getMessage()
            ]);
        }

        $newData['user_id'] = $user->id;
        $newData['is_active'] = 1;
        $newData['username'] = $user->username;
        $newData['level'] = $parent->level + 1;
        $newData['parent_id'] = $parent->id;
        $member = $this->MemberRepository->store($newData);
        $this->BonusRepository->addSponsor($parent, $member);
        $currentMember->register_wallet -= $package->package_amount;
        $currentMember->save();
        \Cache::forget('member.' . $currentMember->id);

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  \Lang::get('message.registerSuccess'),
            'redirect'  =>  route('member.register', ['lang' => \App::getLocale()])
        ]);
    }

    public function postLogin () {
        $data = \Input::get('data');

        try {
            $user = \Sentinel::authenticate([
                'username'  =>  $data['username'],
                'password'  =>  $data['password']
            ], (isset($data['remember'])));

            if (!$user) {
                throw new \Exception(\Lang::get('error.loginError'), 1);
                return false;
            }

            $permissions = $user->permissions;
            if (!isset($permissions['user'])) {
                throw new \Exception(\Lang::get('error.userError'), 1);
                return false;
            } else if ($permissions['user'] != 1) {
                throw new \Exception(\Lang::get('error.userError'), 1);
                return false;
            }

            $member = $user->member;
            if ($member->is_ban) {
                throw new \Exception(\Lang::get('error.userBan'), 1);
                return false;
            }
        } catch (\Exception $e) {
            \Sentinel::logout();
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  $e->getMessage()
            ]);
        }

        return \Response::json([
            'type'      =>  'success',
            'message'   =>  \Lang::get('message.loginSuccess'),
            'redirect'  =>  route('home', ['lang' => \App::getLocale()]),
        ]);
    }

    public function postUpdatePackage () {
        $data = \Input::get('data');
        $user = \Sentinel::getUser();
        $member = $user->member;

        if (isset($data['is_renew'])) {
            if ($member->register_wallet < $member->package_amount) {
                return \Response::json([
                    'type'  =>  'error',
                    'message'   =>  \Lang::get('error.registerCoinNotEnough')
                ]); 
            }
            $member->register_wallet -= $member->package_amount;
        } else {
            if (!$package = $this->PackageRepository->findById(trim($data['package_id']))) {
                return \Response::json([
                    'type'  =>  'error',
                    'message'   =>  \Lang::get('error.packageNotFound')
                ]);
            }
            $original = (float) $member->package_amount;
            $new = (float) $package->package_amount;
            if ($original >= $new) $amount = $original - $new;
            else $amount = $new - $original;
            if ($member->register_wallet < $amount) {
                return \Response::json([
                    'type'  =>  'error',
                    'message'   =>  \Lang::get('error.registerCoinNotEnough')
                ]);
            }
            $member->package_id = $package->id;
            $member->register_wallet -= $amount;
            $member->package_amount = $package->package_amount;
            $member->max_profit = $package->max_profit;
            $member->roi = $package->roi;
            $member->direct = $package->direct;
        }

        $member->current_roi = 0;
        $member->is_active = 1;
        $member->save();
        \Cache::forget('member.' . $member->id);

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  \Lang::get('message.renewSuccess')
        ]);
    }

    public function postAccountUpdate () {
        $data = \Input::get('data');
        $user = \Sentinel::getUser();
        $member = $user->member;

        if (isset($data['password']) || isset($data['first_name'])) {
            if ($data['password'] != '') {
                $userData['password'] = $data['password'];
            }
            if ($data['first_name'] != '') {
                $userData['first_name'] = $data['first_name'];
            }
            try {
                \Sentinel::update($user, $userData);
            } catch (\Exception $e) {
                return \Response::json([
                    'type'  =>  'error',
                    'message'   =>  $e->getMessage()
                ]);
            }
        }

        $allowed = $this->MemberRepository->getAllowedFields();

        foreach ($data as $k => $d) {
            if (in_array($k, $allowed)) {
                if ($d == '') $d = null;
                $member->{$k} = trim($d);
            }
        }

        $member->save();
        \Cache::forget('member.' . $member->id);

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  \Lang::get('message.accountSuccess')
        ]);
    }

    public function postTransferCoin () {
        $data = \Input::get('data');

        if (!$target = $this->MemberRepository->findByUsername(trim($data['member_id']))) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.memberNotFound')
            ]);
        }

        $user = \Sentinel::getUser();
        $member = $user->member;
        $amount = (float) $data['amount'];

        if ($target->username == $member->username) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.transferSelfError')
            ]);
        }

        if ($member->register_wallet < $amount) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.registerCoinNotEnough')
            ]);
        }

        $member->register_wallet -= $amount;
        if ($member->register_wallet < 0) $member->register_wallet = 0;
        $target->register_wallet += $amount;
        $member->save();
        $target->save();

        \Cache::forget('member.' . $member->id);
        \Cache::forget('member.' . $target->id);

        $this->MemberRepository->createCoinHistory($member, $target, $amount);

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  \Lang::get('message.transferSuccess')
        ]);
    }

    public function searchTerm () {
        $term = trim(\Input::get('term'));
        $models = $this->MemberRepository->searchTerm($term);

        return \Response::json([
            'type'  =>  'success',
            'data'  =>  $models
        ]);
    }

    public function getModalDetail () {
        $id = trim(\Input::get('id'));
        $user = \Sentinel::getUser();
        $member = $user->member;
        if ($model = $this->MemberRepository->findById($id)) {
            if ($model->level <= $member->level && $model->id != $member->id) {
                return \Lang::get('error.memberNotAllowed');
            }
            return view('front.network.memberDetail')->with('model', $model);
        }
        else {
            return \Lang::get('error.memberNotFound');
        }
    }

    public function getDirectCount () {
        $user = \Sentinel::getUser();
        $member = $user->member;

        try {
            $models = $this->MemberRepository->findChildren($member);
        } catch (\Exception $e) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  $e->getMessage()
            ]);
        }

        return \Response::json([
            'type'  =>  'success',
            'count' =>  $models->count()
        ]);
    }

    public function getNetwork () {
        $user = \Sentinel::getUser();
        $member = $user->member;

        $type = \Input::get('type');

        if ($type != 'id' && $type != 'username' && $type != 'self') {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.searchError')
            ]);
        }

        if ($type == 'id') {
            if (!$target = $this->MemberRepository->findById(trim(\Input::get('value')))) {
                return \Response::json([
                    'type'  =>  'warning',
                    'message'   =>  \Lang::get('error.memberNotFound')
                ]);
            }
        } else if ($type == 'username') {
            if (!$target = $this->MemberRepository->findByUsername(trim(\Input::get('value')))) {
                return \Response::json([
                    'type'  =>  'warning',
                    'message'   =>  \Lang::get('error.memberNotFound')
                ]);
            }
        } else if ($type == 'self') {
            $target = $member;
        }

        if ($target->level <= $member->level && $type != 'self' && $target->id != $member->id) {
            return \Response::json([
                'type'  =>  'warning',
                'message'   =>  \Lang::get('error.memberNotAllowed')
            ]);
        }

        $models = $this->MemberRepository->findChildren($target);

        return \Response::json([
            'type'  =>  'success',
            'parent' => $target,
            'data' =>  $models
        ]);
    }
}
