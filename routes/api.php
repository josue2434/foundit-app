<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {  //esta ruta es para obtener el usuario autenticado
    return $request->user();
})->middleware('auth:sanctum');


