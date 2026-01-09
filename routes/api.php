<?php

use App\Http\Controllers\Api\YeastRegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('yeast-registrations', [YeastRegistrationController::class, 'store']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('yeast-registrations', [YeastRegistrationController::class, 'index']);
    Route::get('yeast-registrations/{id}', [YeastRegistrationController::class, 'show']);
});
