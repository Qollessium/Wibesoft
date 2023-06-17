<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\User\UserTaskController;
use App\Http\Middleware\IsAdmin;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('auth/register', [AuthController::class, 'register'])->name('register');
Route::post('auth/login', [AuthController::class, 'login'])->name('login');

//allowed if user has token
Route::group([
    'middleware' => [
        'auth:sanctum',
    ],
],function (){
    Route::get('auth/user', [AuthController::class, 'user'])->name('user');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('tasks', UserTaskController::class)->only('index', 'show', 'update');

    //allowed if admin
    Route::group(['prefix' => 'admin', 'middleware' => [IsAdmin::class]], function () {
        Route::resource('tasks', TaskController::class)->only('index', 'store','show', 'update', 'destroy');
        Route::post('tasks/attach', [TaskController::class, 'attach'])->name('task.attach');
        Route::post('tasks/detach', [TaskController::class, 'detach'])->name('task.detach');
    });
    
});
