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
    // view index blog
    return view('blog.index');
});

//ARTICLES
Route::get('/articles/{id}', function () {
    // view all articles
    return view('blog.articles');
});

//LOGIN
Route::get('/login', function () {
    // view login
    return view('auth.login');
});

//REGISTER
Route::get('/register', function () {
    // view register
    return view('auth.register');
});

//LOGOUT
Route::get('/logout', function () {
    // view logout
    return view('auth.logout');
});

//ADMIN
Route::get('/admin', function () {
    // view admin
    return view('admin.index');
});

//ARTICLE
Route::get('/article', function () {
    // view article
    return view('admin.article');
});

//CATEGORY
Route::get('/category', function () {
    // view category
    return view('admin.categories');
});



