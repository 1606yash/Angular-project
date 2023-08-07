<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\DropdownController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/user-registration', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
//Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'api'],function ($router) {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/create-post', [PostController::class, 'create']);
    Route::get('/country', [DropdownController::class, 'index']);
    Route::get('/getStates/{id}', [DropdownController::class, 'getStates']);
    Route::get('/getCities/{id}', [DropdownController::class, 'getCities']);
});
