<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', function () {
    return [
        "posts" => [
            "id" => 1
        ]
    ];
});
