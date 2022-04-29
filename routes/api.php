<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//Auth
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);


Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/logout',[AuthController::class, 'logout']);
});

//Dealers
Route::get('dealers',[DealerController::class, 'index']);
Route::get('dealer/show/{id}',[DealerController::class, 'show']);
Route::get('dealers/search/{string}',[DealerController::class, 'search']);
Route::post('dealer/add',[DealerController::class, 'store']);
Route::post('mail', [DealerController::class, 'init']);
Route::put('dealer/update',[DealerController::class, 'update']);
Route::delete('dealer/delete/{id}',[DealerController::class, 'destroy']);


