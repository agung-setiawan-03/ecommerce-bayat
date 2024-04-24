<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\ProfileController;

// Admin Route
Route::get('dashboard',[AdminController::class,'dashboard'])->name('dashboard');

// Profile Route
Route::get('profile', [ProfileController::class,'index'])->name('profile');
Route::post('profile/update', [ProfileController::class,'updateProfile'])->name('profile.update');
Route::post('profile/update/password', [ProfileController::class,'updatePassword'])->name('password.update');


?>