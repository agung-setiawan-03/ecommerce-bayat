<?php


use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;

// Frontend Route
Route::get('/',[HomeController::class, 'index'])->name('home');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});






require __DIR__.'/auth.php';



// Admin login Route
Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');


Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user'], function(){
    // User dashboard route 
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    // User Profile Route 
    Route::get('profile', [UserProfileController::class, 'index'])->name('profile');
    // User Update Profile Route
    Route::put('profile', [UserProfileController::class, 'updateProfile'])->name('profile.update');
});