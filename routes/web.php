<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Test route to check database connection
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "Database connection successful! Database name: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});
