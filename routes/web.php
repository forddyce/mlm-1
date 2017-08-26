<?php

// \Cache::flush();

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
| 
*/

Route::get('', function() {
    return redirect()->route('home', ['lang' => App::getLocale()]);
});

Route::group(['prefix' => '{lang?}', 'where' => ['lang' => '(en|ch)'], 'middleware' => 'locale'], function () {
	Route::get('login', ['as' => 'login', 'uses' => 'SiteController@getLogin']);
	Route::post('login', ['as' => 'post.login', 'uses' => 'MemberController@postLogin']);
	Route::get('logout', ['as' => 'logout', 'uses' => 'SiteController@getLogout']);
	Route::get('/', ['as' => 'home', 'uses' => 'SiteController@getHome']);
	Route::get('network', ['as' => 'network', 'uses' => 'SiteController@getNetwork']);
	Route::get('account-settings', ['as' => 'settings.main', 'uses' => 'SiteController@getSettingsMain']);
	Route::get('bank-details', ['as' => 'settings.bank', 'uses' => 'SiteController@getSettingsBank']);
	Route::get('register', ['as' => 'member.register', 'uses' => 'SiteController@getRegister']);
	Route::get('member/search-term', 'MemberController@searchTerm');
	Route::get('upgrade', ['as' => 'member.upgrade', 'uses' => 'SiteController@getUpgrade']);
	Route::get('transfer-coin', ['as' => 'transaction.coin', 'uses' => 'SiteController@getTransferCoin']);
	Route::get('withdraw', ['as' => 'transaction.withdraw.cash', 'uses' => 'SiteController@getWithdrawWallet']);

	// Route::get('withdraw/roi-wallet', ['as' => 'transaction.withdraw.roi', 'uses' => 'SiteController@getWithdrawRoiWallet']);
	// Route::post('withdraw/roi', ['as' => 'withdraw.roi', 'uses' => 'TakeController@postWithdrawRoiWallet']);

	Route::get('e-statement', ['as' => 'transaction.statement', 'uses' => 'SiteController@getTransactionStatement']);
	Route::get('financial-statement', ['as' => 'investment.financial', 'uses' => 'SiteController@getInvestmentFinancial']);
});

Route::get('network/search', 'MemberController@getNetwork');
Route::get('member/get-detail', 'MemberController@getModalDetail');
Route::get('member/direct-count', 'MemberController@getDirectCount');
Route::post('account-update', ['as' => 'account.update', 'uses' => 'MemberController@postAccountUpdate']);
Route::post('member/update-withdraw', ['as' => 'member.withdraw.update', 'uses' => 'TakeController@postMemberUpdate']);
Route::post('member/upgrade-package', ['as' => 'member.post.upgrade', 'uses' => 'MemberController@postUpdatePackage']);
Route::post('transfer-coin', ['as' => 'transaction.coin.transfer', 'uses' => 'MemberController@postTransferCoin']);
Route::post('withdraw', ['as' => 'withdraw.cash', 'uses' => 'TakeController@postWithdrawWallet']);


$adminRoute = config('app.adminUrl');

Route::get($adminRoute . '/login', ['as' => 'admin.login', 'uses' => 'Admin\AdminController@getLogin']);
Route::get($adminRoute . '/logout', ['as' => 'admin.logout', 'uses' => 'Admin\AdminController@getLogout']);
Route::post($adminRoute . '/login', ['as' => 'admin.postLogin', 'uses' => 'Admin\AdminController@postLogin']);
Route::get($adminRoute . '/settings', ['as' => 'admin.settings', 'uses' => 'Admin\AdminController@getSettings']);
Route::post($adminRoute. '/update-account', ['as' => 'admin.updateAccount', 'uses' => 'Admin\AdminController@postUpdateAccount']);
Route::get($adminRoute, ['as' => 'admin.index', 'uses' => 'Admin\AdminController@getIndex']);

Route::get($adminRoute . '/member/register', ['as' => 'admin.member.register', 'uses' => 'Admin\AdminController@getMemberRegister']);
Route::get($adminRoute . '/member/list', ['as' => 'admin.member.list', 'uses' => 'Admin\AdminController@getMemberList']);
Route::get($adminRoute . '/member/{id}/edit', ['as' => 'admin.member.edit', 'uses' => 'Admin\AdminController@getEditMember']);
Route::get($adminRoute . '/member/{id}/network', ['as' => 'admin.member.network', 'uses' => 'Admin\AdminController@getMemberNetwork']);
Route::get($adminRoute . '/member-network/{id}', ['as' => 'admin.member.getNetwork', 'uses' => 'Admin\AdminController@checkMemberNetwork']);
Route::post($adminRoute . '/update-member/{id}', ['as' => 'admin.member.update', 'uses' => 'Admin\MemberController@postAdminUpdate']);

Route::get($adminRoute . '/package', ['as' => 'admin.package', 'uses' => 'Admin\AdminController@getPackage']);

Route::get($adminRoute . '/withdraw/list', ['as' => 'admin.withdraw.list', 'uses' => 'Admin\AdminController@getWithdrawList']);
Route::post($adminRoute . '/update-withdraw', ['as' => 'admin.withdraw.update', 'uses' => 'TakeController@postAdminUpdate']);
Route::post($adminRoute . '/member-count', 'Admin\MemberController@count');
Route::post($adminRoute . '/withdraw-count', 'TakeController@count');
