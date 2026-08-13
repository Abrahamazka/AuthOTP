<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function(){
    return view('auth.login');
});
Route::get('/register', function(){
    return view('auth.register');
});
Route::get('/index', function(){
    return view('index');
});
Route::get('/admin', function(){
    return view('admin');
});
Route::get('/forgotpw', function(){
    return view('auth.forgotpw');
});
Route::get('/profile', function(){
    return view('profile');
});
Route::get('/pesan', function () {
    return view('pesan');
});