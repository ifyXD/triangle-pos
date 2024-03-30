<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth'], function () {

    //User Profile
    Route::get('/edit-user/profile', 'ProfileController@edit')->name('profile.edit');
    Route::patch('/edit-user/profile', 'ProfileController@update')->name('profile.update');
    Route::patch('/edit-user/password', 'ProfileController@updatePassword')->name('profile.update.password');

    //Users
    Route::resource('users', 'UsersController')->except('show');

    //Roles
    Route::resource('roles', 'RolesController')->except('show');

});
