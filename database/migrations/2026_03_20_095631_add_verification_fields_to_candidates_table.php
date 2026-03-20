<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            // Add verification status column
            $table->enum('verification_status', [
                'pending', 
                'document_verified', 
                'background_checked', 
                'fully_verified', 
                'rejected'
            ])->default('pending')->after('status');
            
            // Add verification notes column
            $table->text('verification_notes')->nullable()->after('verification_status');
        });
    }

    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn(['verification_status', 'verification_notes']);
        });
    }
};