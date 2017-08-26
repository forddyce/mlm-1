<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (\Sentinel::check()) {
                $user = \Sentinel::getUser();
                \View::share(['user' => $user]);
                $permissions = $user->permissions;
                if (isset($permissions['user'])) {
                    $member = $user->member;
                    $member = \Cache::remember('member.' . $member->id, 60, function () use ($member) {
                        return $member;
                    });
                    \View::share(['member' => $member]);
                }
            }
            return $next($request);
        });
    }
}
