<?php

use Illuminate\Support\Facades\Route;

Route::get('/articles', function() {
    return 'Articles Route';
});

Route::get('/articles/detail/{id}', function ($id) {
    return "Article Detail - $id";
});

Route::get('/', function () {
    return view('welcome');
});
