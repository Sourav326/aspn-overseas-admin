<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('client_id')->unique(); // CLI202400001
            
            // Personal Information
            $table->string('name');
            $table->string('organization_name');
            $table->string('phone')->unique();
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->unique();
            $table->string('industry_type');
            
            // Status
            $table->enum('status', [
                'pending', 
                'approved', 
                'active', 
                'suspended', 
                'rejected'
            ])->default('pending');
            
            // Verification
            $table->enum('verification_status', [
                'pending', 
                'verified', 
                'rejected'
            ])->default('pending');
            
            $table->text('verification_notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            
            // Tracking
            $table->string('registered_from_ip')->nullable();
            $table->string('registered_from_device')->nullable();
            $table->timestamp('registered_at')->nullable();
            
            // Foreign Keys
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('verification_status');
            $table->index('industry_type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};