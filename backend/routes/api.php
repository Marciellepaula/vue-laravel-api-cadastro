<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\SendMailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->group(
    function () {
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
        Route::apiResource('cadastro', CadastroController::class);
        Route::post('cadastro/{id}', [CadastroController::class, 'update']);
    }
);

// // Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
// Route::apiResource('/cadastro', CadastroController::class);

Route::get('/sendemail/{id}', [SendMailController::class, 'enviarEmail']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
