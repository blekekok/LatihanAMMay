<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AdminController;

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

Route::get('universities', [UniversityController::class, 'index']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('create', [AuthController::class, 'create']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::group(['prefix' => 'user'], function () {
    Route::get('emailexist', [UserController::class, 'emailExist']);
});

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('profile', [UserController::class, 'getProfile']);
    Route::get('files', [UserController::class, 'getFiles']);
    Route::get('userprofile', [UserController::class, 'userProfile']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('dashboard', [AdminController::class, 'getDashboard']);
    Route::post('approveuser', [AdminController::class, 'userApprove']);
    Route::post('rejectuser', [AdminController::class, 'userReject']);
});

Route::get('file/categories', [FileController::class, 'getCategories']);
