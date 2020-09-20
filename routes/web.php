<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('login');
});

Route::get('/login',"adminController@login");
Route::post('/login',"adminController@loginUser");
Route::get('/invoices/{pagesize?}',"invoicesController@index");
Route::get('/inv_add',"invoicesController@add");
Route::get('/inv_details/{id}',"invoicesController@details");
Route::get('/inv_edit/{id}',"invoicesController@edit");
Route::post('/inv_edit',"invoicesController@saveedit");
Route::post('/inv_add',"invoicesController@save");
Route::get('/teachers/{pagesize?}',"teachersController@index");
Route::get('/test',"testController@index");

Route::post('/itemadd',"testController@saveitem");
Route::post('/changeposition',"testController@change");



Route::get('/add/{id?}',"teachersController@addTeacher");
Route::get('/details/{id?}',"teachersController@show");
Route::post('/add',"teachersController@addTeacher");
Route::post('/deleteitem',"teachersController@deleteitem");
Route::post('/makeattendance',"teachersController@makeattendance");


