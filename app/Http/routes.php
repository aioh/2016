<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Event::listen('illuminate.query', function($sql){
	// var_dump($sql);
	// echo '<br>';
});
Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[a-z0-9-]+');
Route::pattern('other_links', '(.*)');

Route::get('system','System\AuthController@login');
Route::get('system/login','System\AuthController@login');
Route::post('system/login','System\AuthController@auth');
Route::get('system/logout','System\AuthController@logout');
Route::get('system/dashboard','System\SystemController@dashboard');
Route::get('system/upload/file','System\SystemController@uploadFileFrom');
Route::get('system/upload/file/{id}','System\SystemController@uploadFileFrom');
Route::post('system/load/preview','System\SystemController@loadPreview');
Route::post('system/upload/file','System\SystemController@uploadFile');
Route::put('system/upload/file/{id}','System\SystemController@uploadFile');
Route::post('system/delete/file','System\SystemController@deleteFile');

Route::get('system/posts/get-all', 'System\PostController@getAjax');
Route::resource('system/posts', 'System\PostController',array('except'=>array('show')));
Route::get('system/users/get-all', 'System\UserController@getAjax');
Route::resource('system/users', 'System\UserController',array('except'=>array('show')));
Route::get('system/sliders/get-all', 'System\SlideController@getAjax');
Route::resource('system/sliders', 'System\SlideController',array('except'=>array('show')));
Route::put('system/settings', 'System\SettingController@save');
Route::get('system/settings/show', 'System\SettingController@show');
Route::get('system/settings/get-all', 'System\SettingController@getAjax');
Route::resource('system/settings', 'System\SettingController');
Route::get('system/templates/get-all', 'System\TemplateController@getAjax');
Route::resource('system/templates', 'System\TemplateController');
Route::get('system/templates/add/field', 'System\TemplateController@addField');
Route::get('system/templates/add/image', 'System\TemplateController@addImage');
Route::get('system/menus/get-all', 'System\MenuController@getAjax');
Route::resource('system/menus', 'System\MenuController');
Route::get('system/languages/get-all', 'System\LanguageController@getAjax');
Route::resource('system/languages', 'System\LanguageController',array('except'=>array('show')));

Route::get('/affiliate/line.xml', 'LineController@index');

Route::get('system/code',function(){
	return view('system.code');
});

Route::get('search', 'RoutingController@search');

Route::get('vdo-channel',function(){
	return redirect('https://www.youtube.com/channel/UCIVQq_FmZC4sdpH_AATZr5A');	
});

Route::get('/changeLanguage/{id}', function(Request $request,$id){
	$language = \App\Language::find($id);
	Session::put('language_local',$language->key);
	return Redirect::back();
});

Route::post('sending','RoutingController@sending');

Route::get('{other_links?}?page={page}','RoutingController@index');
Route::get('{other_links?}','RoutingController@index');