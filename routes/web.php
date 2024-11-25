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

// home
Route::get('/', 'HomeController@index')->name('home');
// незабыват прописать user.login в Authenticate.php
Route::post('/', 'HomeController@store')->name('post.store');
// Route::post('/', 'HomeController@store')->name('post.store');
Route::delete('/', 'HomeController@delete')->name('post.delete');

// ADMIN
Route::resource('admin', 'AdminController')->middleware('admin');

//                                  регистрация

// проверка авторизованности и запрета на вход в аут и регистр
// по умалчанию редирект на /home для перенаправления на '/' изменить путь на return redirect('/'); в файле 
// http/middleware так же можно посмотреть в файле kernel.php
//                                  Вариант 1
// Route::group(
//     ['middleware' => 'guest'],
//     function () {
//         Route::get('/register', "UserController@register")->name('user.register');
//         Route::get('/login', "UserController@login")->name('user.login');
//     }
// );
//                                   Вариант 2
Route::middleware('guest')->group(function () {
    Route::get('register', 'UserController@register')->name('user.register');
    Route::get('login', 'UserController@login')->name('user.login');
    Route::post('register', 'UserController@store')->name('user.store');
    Route::post('login', 'UserController@checkLogin')->name('user.checkLogin');
});

//                              без проверки
// Route::get('/register', "UserController@register")->name('user.register');
// Route::post('/register', "UserController@store")->name('user.store');
//                              авторизация
// Route::get('/login', "UserController@login")->name('user.login');
// Route::post('/login', "UserController@checkLogin")->name('user.checkLogin');
// выход авторизованного пльзователя
Route::get('/logout', "UserController@logout")->name('user.logout');
