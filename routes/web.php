<?php

use App\Http\Controllers\YeastRegistrationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('home');

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Yeast Registrations
    Route::get('yeast-registrations', [YeastRegistrationController::class, 'index'])->name('yeast-registrations.index');
    Route::get('yeast-registrations/{yeastRegistration}', [YeastRegistrationController::class, 'show'])->name('yeast-registrations.show');
    Route::get('yeast-registrations-export', [YeastRegistrationController::class, 'export'])->name('yeast-registrations.export');
    Route::get('yeast-registrations/{yeastRegistration}/download/{documentType}', [YeastRegistrationController::class, 'downloadDocument'])->name('yeast-registrations.download');
});

require __DIR__.'/settings.php';
