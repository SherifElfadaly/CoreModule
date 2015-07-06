<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/admin', ['middleware' => 'AclAuthenticate', function(){
    return view('core::home');
}]);

Route::get('/admin/changeLanguage/{key}', function($key){
	if($key)
	{
		\Session::put('language', $key);
		\Lang::setlocale($key);
	}
	return redirect()->back();
});

Route::get('/{page?}', 'SiteController@showPage');
Route::get('/contentitem/{page?}/{idOrContentType?}', 'SiteController@showContent');
Route::get('/section/{page?}/{contentType?}/{id?}', 'SiteController@showSection');
Route::get('/tag/{page?}/{contentType?}/{id?}', 'SiteController@showTag');
Route::get('/archive/{page?}/{contentType?}/{type?}/{value?}', 'SiteController@showArchive');