<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('candidate_id')->unique(); // Custom ID like CAN20240001
            
            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('whatsapp_number')->nullable();
            $table->string('passport_number')->unique()->nullable();
            $table->date('passport_expiry_date')->nullable();
            
            // Experience
            $table->integer('indian_experience_years')->default(0);
            $table->integer('overseas_experience_years')->default(0);
            
            // Professional Information
            $table->string('trade_name');
            $table->string('industry_type');
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
            
            // Status
            $table->enum('status', [
                'pending', 
                'under_review', 
                'shortlisted', 
                'selected', 
                'rejected', 
                'placed'
            ])->default('pending');
            
            $table->enum('verification_status', [
                'pending', 
                'document_verified', 
                'background_checked', 
                'fully_verified', 
                'rejected'
            ])->default('pending');
            
            // Tracking
            $table->string('registered_from_ip')->nullable();
            $table->string('registered_from_device')->nullable();
            $table->timestamp('registered_at')->nullable();
            
            // Foreign Keys
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('verification_status');
            $table->index('trade_name');
            $table->index('industry_type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};