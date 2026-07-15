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
        Schema::table('quizzes', function (Blueprint $table) {
            // Adds the column to store custom questionnaire matrices as a JSON array
            if (!Schema::hasColumn('quizzes', 'custom_questions')) {
                $table->json('custom_questions')->nullable()->after('description');
            }
            
            // Adds scheduling opening and closing timestamp tracking windows
            if (!Schema::hasColumn('quizzes', 'starts_at')) {
                $table->dateTime('starts_at')->nullable()->after('custom_questions');
            }
            if (!Schema::hasColumn('quizzes', 'ends_at')) {
                $table->dateTime('ends_at')->nullable()->after('starts_at');
            }
            
            // Adds the status tracking field needed to open/close evaluations
            if (!Schema::hasColumn('quizzes', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('ends_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn(['custom_questions', 'starts_at', 'ends_at', 'is_active']);
        });
    }
};