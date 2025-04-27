<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CryptoController;


//Route::get('/', HomeController::class);

/*Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/', HomeController::class);

Route::get('/', [HomeController::class, 'index']);

Route::get('visualizar', [HomeController::class, 'view']);

Route::get('getInfo', [CryptoController::class, 'getAllCryptoPrices']);


