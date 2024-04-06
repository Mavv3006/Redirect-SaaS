<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('profile/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('redirect/create', [RedirectController::class, 'create'])
    ->middleware(['auth']);


require __DIR__ . '/auth.php';


Route::get('{path}', [RedirectController::class, 'redirect'])
    ->where('path', '[a-zA-Z\-\_1-9]+');
