<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('app');
});


Route::get('/app', function () {
	return view('app');
});

Route::get('/plans', function () {
	return view('plans');
});

Route::get('/contact', function () {
	return view('contact');
});

Route::get('/template', function () {
	return view('template');
});

Route::get('/history', function () {
	return view('history');
});

Route::get('/account', function () {
	return view('account');
});

Route::get('/customize', function () {
	return view('customize');
});

Route::get('/createUsers', function () {
	return view('createUsers');
});

Route::get('/listUsers', function () {
	return view('listUsers');
});
