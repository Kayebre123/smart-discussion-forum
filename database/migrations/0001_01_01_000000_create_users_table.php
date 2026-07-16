<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // System Roles & Account State Controls
            $table->enum('role', ['administrator', 'lecturer', 'student'])->default('student');
            $table->string('status')->default('active'); // Supports active, suspended, restricted, blacklisted smoothly
            
            // Group association is stored here and the foreign key is added later
            // so the relationship is created only after the groups table exists.
            $table->foreignId('group_id')->nullable();
            
            // Infraction & Governance Fields
            $table->integer('warnings_count')->default(0); // Holds warning increments
            $table->timestamp('blacklist_until')->nullable(); // For temporary suspensions
            $table->timestamp('rules_accepted_at')->nullable(); // Tracks mandatory rule acceptance
            
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};