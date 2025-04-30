<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceProviderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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



Route::get('/', [ServiceProviderController::class, 'index'])->name('providers.index');
Route::get('/{provider}', [ServiceProviderController::class, 'show'])
    ->middleware(['auth'])
    ->name('providers.show');


require __DIR__ . '/auth.php';
