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
use App\Priority;
use App\Subcategory;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/info', function () {
    return view('info');
});

Auth::routes();

Route::get('change-password', 'Auth\UpdatePasswordController@index')->name('password.form');
Route::post('change-password', 'Auth\UpdatePasswordController@update')->name('password.update');

Route::get('/home', 'HomeController@index');

Route::get('/priorities', 'PrioritiesController@index')->name('priorities');
Route::get('/priorities/create', 'PrioritiesController@create');
Route::get('/priorities/{priority}', 'PrioritiesController@show');
Route::post('/priorities', 'PrioritiesController@store');
Route::get('/priorities/{priority}/edit', 'PrioritiesController@edit');
Route::put('/priorities/{priority}', 'PrioritiesController@update');
Route::delete('priorities/{priority}', 'PrioritiesController@destroy')->name('priority-delete');

Route::get('/subcategories', 'SubcategoriesController@index');
Route::get('/subcategories/create', 'SubcategoriesController@create');
Route::get('/subcategories/{subcategory}/', 'SubcategoriesController@show');
Route::post('/subcategories', 'SubcategoriesController@store');
Route::put('/subcategories/{subcategory}', 'SubcategoriesController@update');
Route::delete('subcategories/{subcategory}', 'SubcategoriesController@destroy');

Route::get('/acts', 'ActsController@index');
Route::get('/acts/create', 'ActsController@create');
Route::get('/acts/{act}', 'ActsController@show');
Route::post('/acts', 'ActsController@store');
Route::put('/acts/{act}', 'ActsController@update');
Route::delete('acts/{act}', 'ActsController@destroy');

Route::get('/actions', 'ActionsController@index');
Route::get('/actions/create', 'ActionsController@create');
Route::get('/action', 'ActionsController@showAtDay');
Route::post('/actions', 'ActionsController@store');
Route::get('/actions/{action}/edit', 'ActionsController@edit');
Route::put('/actions/{action}/edit', 'ActionsController@update');
Route::get('/actions/editOnDate', 'ActionsController@editOnDate');
Route::delete('actions/delete', 'ActionsController@destroyOnDate');
Route::put('/actions/update', 'ActionsController@updateOnDate');

Route::get('/reports', 'ReportsController@index');
Route::get('/reports/lastmonth', 'ReportsController@lastmonth');
Route::get('/reports/{action}', 'ReportsController@show');
