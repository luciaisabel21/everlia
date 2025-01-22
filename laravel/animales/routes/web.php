<?php

use App\Http\Controllers\AnimalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/hello", function () {
    return "hola";
    });

Route::get("user/{id}", function (string $id) {
    return "hola user con id $id";
    });



Route::resource("/animal", AnimalController::class);