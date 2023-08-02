<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

// Route::get('/', function () {
//     return view('cms.parent');
// });
Route::prefix('cms/admin')->group(function () {
    Route::view('/', 'cms.parent');
    Route::get('/users', [UserController::class,'index'])->name('users.index');

    Route::get('/create', [UserController::class,'create'])->name('users.create');
    Route::post('/users', [UserController::class,'store'])->name('users.store');

    Route::get('/users/{id}/edit', [UserController::class,'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class,'update'])->name('users.update');

    Route::delete('/users/{id}', [UserController::class,'destroy'])->name('users.delete');

    Route::get('/users/search', [UserController::class,'search'])->name('users.search');


});
