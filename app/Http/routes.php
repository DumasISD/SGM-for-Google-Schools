<?php

/****************   Model binding into route **************************/
Route::model('article', 'App\Article');
Route::model('language', 'App\Language');
Route::model('smartgroup', 'App\SmartGroup');
Route::model('googledomain', 'App\GoogleDomain');
Route::model('photoalbum', 'App\PhotoAlbum');
Route::model('photo', 'App\Photo');
Route::model('user', 'App\User');
Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[0-9a-z-_]+');

/***************    Site routes  **********************************/
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');
Route::get('users', 'HomeController@getUsers');
Route::get('groups', 'HomeController@getGroups');
Route::post('auth/login', 'Auth\AuthController@login');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/***************    Admin routes  **********************************/
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {

    # Admin Dashboard
    Route::get('dashboard', 'Admin\DashboardController@index');

    # Language
    Route::get('language/data', 'Admin\LanguageController@data');
    Route::get('language/{language}/show', 'Admin\LanguageController@show');
    Route::get('language/{language}/edit', 'Admin\LanguageController@edit');
    Route::get('language/{language}/delete', 'Admin\LanguageController@delete');
    Route::resource('language', 'Admin\LanguageController');


    Route::get('smartgroup/data', 'Admin\SmartGroupController@data');
    Route::get('smartgroup/{smartgroup}/show', 'Admin\SmartGroupController@show');
    Route::get('smartgroup/{smartgroup}/edit', 'Admin\SmartGroupController@edit');
    Route::get('smartgroup/{smartgroup}/delete', 'Admin\SmartGroupController@delete');
    Route::resource('smartgroup', 'Admin\SmartGroupController');

    Route::get('googledomain/data', 'Admin\GoogleDomainController@data');
    Route::get('googledomain/{googledomain}/show', 'Admin\GoogleDomainController@show');
    Route::get('googledomain/{googledomain}/edit', 'Admin\GoogleDomainController@edit');
    Route::get('googledomain/{googledomain}/delete', 'Admin\GoogleDomainController@delete');
    Route::resource('googledomain', 'Admin\GoogleDomainController');


    # Article category
    Route::get('articlecategory/data', 'Admin\ArticleCategoriesController@data');
    Route::get('articlecategory/{articlecategory}/show', 'Admin\ArticleCategoriesController@show');
    Route::get('articlecategory/{articlecategory}/edit', 'Admin\ArticleCategoriesController@edit');
    Route::get('articlecategory/{articlecategory}/delete', 'Admin\ArticleCategoriesController@delete');
    Route::get('articlecategory/reorder', 'ArticleCategoriesController@getReorder');
    Route::resource('articlecategory', 'Admin\ArticleCategoriesController');

	 # groups
    Route::get('google-groups', 'Admin\GoogleController@listGroups');
	Route::get('make-smartgroup/{existing_google_group_id}', 'Admin\GoogleController@getSmartGroupCreate');
	Route::get('edit-smartgroup/{smartgroup}/edit', 'Admin\GoogleController@getSmartGroupEdit');
	Route::post('smartgroup/add', 'Admin\SmartGroupController@saveSmartGroup');
	Route::post('edit-smartgroup/{smartgroup}/edit', 'Admin\SmartGroupController@updateSmartGroup');
    Route::get('google-groups/{google_domain_id}', 'Admin\GoogleController@listGroups2');

	 # google users
    Route::get('google-users', 'Admin\GoogleController@listGoogleUsers');
    Route::get('google-users/{google_domain_id}', 'Admin\GoogleController@listGoogleUsers2');

    # Users
    Route::get('user/data', 'Admin\UserController@data');
    Route::get('user/{user}/show', 'Admin\UserController@show');
    Route::get('user/{user}/edit', 'Admin\UserController@edit');
    Route::get('user/{user}/delete', 'Admin\UserController@delete');
    Route::resource('user', 'Admin\UserController');
});
