<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;


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


Auth::routes();

Route::get('/', [ContactController::class, 'index'])->name('index');
Route::post('csv/import', [ContactController::class, 'csvImport'])->name('contact.csv.import');
Route::post('csv/export', [ContactController::class, 'csvExport'])->name('contact.csv.export');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
