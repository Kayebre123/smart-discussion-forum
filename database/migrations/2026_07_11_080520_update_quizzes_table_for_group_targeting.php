<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // Drop constraint issue by redefining or making sure fields exist
            if (!Schema::hasColumn('quizzes', 'group_id')) {
                $table->foreignId('group_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('quizzes', 'custom_questions')) {
                $table->json('custom_questions')->nullable()->after('description');
            }
            if (!Schema::hasColumn('quizzes', 'opens_at')) {
                $table->dateTime('opens_at')->nullable()->after('custom_questions');
            }
            if (!Schema::hasColumn('quizzes', 'duration_minutes')) {
                $table->integer('duration_minutes')->nullable()->after('opens_at');
            }
            if (!Schema::hasColumn('quizzes', 'ends_at')) {
                $table->dateTime('ends_at')->nullable()->after('duration_minutes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {$table->dropColumn(['group_id', 'custom_questions', 'opens_at', 'duration_minutes', 'ends_at']);
        });
    }
};