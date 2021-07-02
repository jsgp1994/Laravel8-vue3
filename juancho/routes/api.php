<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
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

//Route::resource('document', DocumentController::class);
Route::post('registrer',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login'])->name("login");

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('document')->group(function () {
        Route::post('/list', [DocumentController::class, 'list']);
    });
});


/*Route::get('testing', function () {
    return 'hello word';
});*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
