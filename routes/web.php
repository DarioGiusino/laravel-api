<?php

use App\Http\Controllers\admin\HomeController as AdminHomeController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\TechnologyController;
use App\Http\Controllers\admin\TypeController;
use App\Http\Controllers\guest\HomeController as GuestHomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// # guest
Route::get('/', [GuestHomeController::class, 'index'])->name('guest.home');

// # admin
Route::middleware('auth')->name('admin.')->prefix('/admin')->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name('home');
    Route::resource('projects', ProjectController::class);
    Route::resource('types', TypeController::class);
    Route::patch('types/{type}/patch', [TypeController::class, 'patch'])->name('types.patch');
    Route::resource('technologies', TechnologyController::class);
    Route::patch('technologies/{technology}/patch', [TechnologyController::class, 'patch'])->name('technologies.patch');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
