<?php

use App\Http\Controllers\ServiceProviderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [ServiceProviderController::class, 'index'])->name('index');

Route::get('/{provider}', [ServiceProviderController::class, 'show'])->name('show');


require __DIR__ . '/auth.php';
