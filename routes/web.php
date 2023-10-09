<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/ships');
});

Route::get('/ships', [ShipController::class, 'index']);
Route::get('/ships/{ship}/edit', [ShipController::class, 'edit']);
Route::put('/ships/{ship}', [ShipController::class, 'update']);
