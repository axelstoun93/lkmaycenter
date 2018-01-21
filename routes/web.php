<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
# Регистрация
Route::get('/',['uses' => 'Auth\LoginController@showLoginForm','as'=>'login']);
Route::post('/','Auth\LoginController@login');
Route::post('logout','Auth\LoginController@logout')->name('logout');
Route::post('email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('reset','Auth\ResetPasswordController@reset');
Route::get('reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::get('register','Auth\RegisterController@showRegistrationForm')->name('register');

# Внешний роут показывает работы партнеров
Route::resource('jobs','JobsController',[
    'names' => [
        'index'=>'jobs.index',
        'show' => 'jobs.readmore'
    ]]);
#Внешний роут для телевизора академии
Route::resource('/tv','TvController',[
    'names' => [
        'index'  => 'tv',
        'show' => 'tv.show'
    ]
]);
# Все роуты администраторов
Route::group(['prefix'=> 'administrator','middleware' => ['auth','role_admin']], function ()
{
    Route::resource('/','Administrator\IndexController',[
        'only' =>['index'],
        'names' => ['index'=>'home']
    ]);
    Route::resource('/users','Administrator\UsersController',[
        'names' => [
            'index'=>'users',
            'edit' => 'users.edit',
            'show' => 'users.show',
            'create' => 'users.create',
            'update' => 'users.update'
        ]
    ]);
    Route::resource('/offsets','Administrator\OffsetsController',[
        'names' => [
            'index'=>'administrator-offsets',
            'edit' => 'administrator-offsets.edit',
            'create' => 'administrator-offsets.create'
        ]
    ]);

    Route::post('/offsets/{id}', 'Administrator\OffsetsController@update');
    Route::get('/offsets/{month}/{years}','Administrator\OffsetsController@getMonthYears')->where(['month' => '[0-9]{1,2}+', 'years' => '[0-9]{4}+']);

    Route::resource('/logs','Administrator\LogsController',[
        'only' =>['index'],
        'names' => ['index'=>'logs']
    ]);
});
# Все роуты менеджеров
Route::group(['prefix'=> 'manager','middleware'=> ['auth','role_manager']], function ()
{
   Route::resource('/','Manager\IndexController',[
       'only' =>['index'],
       'names' => ['index'=>'home']
   ]);
   Route::resource('/partners','Manager\PartnersController',[
       'names' => [
           'index'=>'partners',
           'edit' => 'partners.edit',
           'show' => 'partners.show',
           'create' => 'partners.create',
           'update' => 'partners.update'
       ]
   ]);
   Route::resource('/offsets','Manager\OffsetsController',[
       'names' => [
           'index'=>'offsets',
           'edit' => 'offsets.edit',
           'create' => 'offsets.create'
       ]
   ]);

    Route::post('/offsets/{id}', 'Manager\OffsetsController@update');
    Route::get('/offsets/{month}/{years}','Manager\OffsetsController@getMonthYears')->where(['month' => '[0-9]{1,2}+', 'years' => '[0-9]{4}+']);

    Route::resource('/schedule','Manager\ScheduleController',[
        'names' => [
            'index'  => 'schedule',
            'edit'   => 'schedule.edit',
            'show'   => 'schedule.show',
            'create' => 'schedule.create',
            'update' => 'schedule.update'
        ]
    ]);
    Route::post('/schedule/{id}', 'Manager\ScheduleController@update');
    Route::get('/schedule/{month}/{years}','Manager\ScheduleController@getMonthYears')->where(['month' => '[0-9]{1,2}+', 'years' => '[0-9]{4}+']);



});
# Все роуты партнеров
Route::group(['prefix'=> 'partner','middleware' => ['auth','role_partner']], function ()
{
    Route::resource('/','Partner\IndexController',[
        'only' =>['index'],
        'names' => ['index'=>'home']
    ]);
    Route::resource('/profile','Partner\ProfileController',[
        'names' =>
            [
                'index'=>'profile',
                'update' => 'profile.update'
            ]
    ]);
    Route::resource('/jobs','Partner\MyJobsController',[
        'names' =>
            [

                'index'=>'jobs',
                'update' => 'jobs.update',
                'edit' => 'jobs.edit',
                'create' => 'jobs.create',

            ]
    ]);
    Route::resource('/examinations','Partner\ExaminationsController',[
        'names' =>
            [
                 'index'=>'examinations',
                 'update' => 'examinations.update',
                 'create' => 'examinations.create',
                 'show' => 'examinations.show',
            ]
    ]);
    Route::get('/examinations/{month}/{years}','Partner\ExaminationsController@getMonthYears')->where(['month' => '[0-9]{1,2}+', 'years' => '[0-9]{4}+']);
});