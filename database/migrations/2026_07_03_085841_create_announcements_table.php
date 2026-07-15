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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            
            // Connects the announcement to the User (Lecturer or Admin) who posted it
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // The headline and text body of the announcement
            $table->string('title');
            $table->text('content');
            
            // Allows targeting specific groups (e.g., default is 'student')
            $table->string('target_audience')->default('student');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};