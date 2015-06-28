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

Route::get('/{page?}', 'PagesController@showPage');