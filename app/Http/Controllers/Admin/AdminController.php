<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->middleware('admin', ['except' => ['getLogin', 'postLogin', 'getLogout']]);
    }

    public function getLogin () {
        return view('back.login');
    }

    public function getIndex () {
        return view('back.home');
    }

    public function getSettings () {
        return view('back.settings');
    }

    public function getLogout () {
        if ($user = \Sentinel::getUser()) {
            \Sentinel::logout($user);
        }
        return view('back.login');
    }

    public function postLogin () {
        $data = \Input::get('data');

        try {
            $user = \Sentinel::authenticate([
                'username'  =>  $data['username'],
                'password'  =>  $data['password']
            ], (isset($data['remember'])));

            if (!$user) {
                throw new \Exception('Username / Password do not match.', 1);
                return false;
            }

            $permissions = $user->permissions;
            if (!isset($permissions['admin'])) {
                throw new \Exception('Cannot login here.', 1);
                return false;
            } else if ($permissions['admin'] != 1) {
                throw new \Exception('Cannot login here.', 1);
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
            'message'   =>  'Redirecting to dashboard..',
            'redirect'  =>  route('admin.index'),
        ]);
    }

    public function postUpdateAccount () {
        $data = \Input::get('data');
        $user = \Sentinel::getUser();

        if ($data['password'] != '') {
            try {
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

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  'Account updated.'
        ]);
    }

    public function getMemberList () {
        return view('back.member.list');
    }

    public function getMemberRegister () {
        return view('back.member.register');
    }

    public function getWithdrawList () {
        return view('back.withdraw.list');
    }

    public function getPackage () {
        return view('back.package.list');
    }

    public function getEditMember ($id) {
        $instance = new \App\Models\Member;
        if (!$model = $instance->where('id', trim($id))->first()) {
            return redirect()->route('admin.member.list')->with('flashMessage', [
                'class'  =>  'warning',
                'message'   =>  'Member not found.'
            ]);
        }
        return view('back.member.edit')->with('model', $model);
    }

    public function getMemberNetwork ($id) {
        $instance = new \App\Models\Member;
        if (!$model = $instance->where('id', trim($id))->first()) {
            return redirect()->route('admin.member.list')->with('flashMessage', [
                'class'  =>  'warning',
                'message'   =>  'Member not found.'
            ]);
        }
        return view('back.member.network')->with('model', $model);
    }

    public function checkMemberNetwork ($id) {
        $instance = new \App\Models\Member;
        if (!$parent = $instance->where('id', trim($id))->first()) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  'Member not found.'
            ]);
        }

        $parent->withdrawTotal = 0;

        if ($takes = $parent->takes()->get()) {
            foreach ($takes as $take) {
                $parent->withdrawTotal += $take->amount;
            }
        }

        $repo = new \App\Repositories\MemberRepository($instance);
        $models = $repo->findChildren($parent);
        if (count($models) > 0) {
            foreach ($models as $model) {
                $model->withdrawTotal = 0;
                if ($takes = $model->takes()->get()) {
                    foreach ($takes as $take) {
                        $model->withdrawTotal += $take->amount;
                    }
                }
            }
        }

        return \Response::json([
            'type'  =>  'success',
            'parent' => $parent,
            'data' =>  $models
        ]);
    }
}
