<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CandidateRegistrationController;
use App\Http\Controllers\Api\EmployerRegistrationController;



// Public API routes (no authentication required)
Route::prefix('v1')->group(function () {
    
    // Candidate registration endpoints
    Route::post('/candidates/register', [CandidateRegistrationController::class, 'register']);
    Route::get('/candidates/status/{email}', [CandidateRegistrationController::class, 'checkStatus']);
    // Employer (Client) registration
    Route::post('/employers/register', [EmployerRegistrationController::class, 'register']);
});

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});