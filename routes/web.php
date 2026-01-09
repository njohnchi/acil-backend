<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('home');

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
