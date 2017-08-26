<?php

namespace App\Http\Controllers\Admin;

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
        $this->middleware('admin');
        $this->MemberRepository = $MemberRepository;
        $this->PackageRepository = $PackageRepository;
        $this->BonusRepository = $BonusRepository;
    }

    public function index (Datatables $datatables) {
        return $this->MemberRepository->search($datatables);
    }

    public function show ($id) {
        if (!$model = $this->MemberRepository->findById(trim($id))) {
            return 'Member not found.';
        }
        return view('back.member.detail')->with('model', $model);
    }

    public function count () {
        $total = $this->MemberRepository->getTotal();
        return \Response::json([
            'type'  =>  'success',
            'total' =>  $total
        ]);
    }

    public function postAdminUpdate ($id) {
        $data = \Input::get('data');

        if (!$model = $this->MemberRepository->findById(trim($id))) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  'Member not found.'
            ]);
        }

        if ($data['password'] != '') {
            try {
                $user = $model->user;
                \Sentinel::update($user, [
                    'password'  =>  trim($data['password'])
                ]);
            } catch (\Exception $e) {
                return \Response::json([
                    'type'  =>  'error',
                    'message'   =>  $e->getMessage()
                ]);
            }
        }

        $newData = [];
        $allowed = $this->MemberRepository->getAllowedFields();

        foreach ($data as $k => $d) {
            if (in_array($k, $allowed)) {
                if ($d == '') $d = null;
                $newData[$k] = trim($d);
            }
        }

        $boolean = $this->MemberRepository->getBooleanFields();
        foreach ($boolean as $b) {
            if (isset($data[$b])) $newData[$b] = 1;
            else $newData[$b] = 0;
        }

        $this->MemberRepository->update($model, $newData);

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  'Member update successful.'
        ]);
    }

    public function store () {
        $data = \Input::get('data');

        if (!$package = $this->PackageRepository->findById(trim($data['package_id']))) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  'Package not found.'
            ]);
        }

        if ($data['upline_id'] != '') {
            if (!$parent = $this->MemberRepository->findByUsername(trim($data['upline_id']))) {
                return \Response::json([
                    'type'  =>  'error',
                    'message'   =>  'Upline not found.'
                ]); 
            }
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
                throw new \Exception("Username " . $data['username'] . " already exists.", 1);
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
        $newData['parent_id'] = isset($parent) ? $parent->id : 0;
        $newData['level'] = isset($parent) ? $parent->level + 1 : 1;
        $member = $this->MemberRepository->store($newData);

        if (isset($parent)) {
            $this->BonusRepository->addSponsor($parent, $member);
        }

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  'Registration successful.',
            'redirect'  =>  route('admin.member.register')
        ]);
    }
}
