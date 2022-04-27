<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('dealers',[DealerController::class, 'index']);
Route::put('dealer/update',[DealerController::class, 'update']);
Route::post('dealer/add',[DealerController::class, 'store']);
Route::get('dealer/show/{id}',[DealerController::class, 'show']);
Route::delete('dealer/delete/{id}',[DealerController::class, 'destroy']);
Route::get('dealers/search/{string}',[DealerController::class, 'search']);
Route::post('mail', [DealerController::class, 'init']);
