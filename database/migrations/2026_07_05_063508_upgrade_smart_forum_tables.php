<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Upgrade Users Table for Status, Warnings, and Restrictions
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active'); // active, warning_1, warning_2, blacklisted, restricted
            }
            if (!Schema::hasColumn('users', 'warnings_count')) {
                $table->integer('warnings_count')->default(0);
            }
            if (!Schema::hasColumn('users', 'blacklist_until')) {
                $table->timestamp('blacklist_until')->nullable();
            }
            if (!Schema::hasColumn('users', 'rules_accepted_at')) {
                $table->timestamp('rules_accepted_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'last_active_at')) {
                $table->timestamp('last_active_at')->nullable();
            }
        });

        // 2. Upgrade Topics Table for Moderation & Accepted Answers
        Schema::table('topics', function (Blueprint $table) {
            if (!Schema::hasColumn('topics', 'is_resolved')) {
                $table->boolean('is_resolved')->default(false);
            }
            if (!Schema::hasColumn('topics', 'accepted_reply_id')) {
                $table->bigInteger('accepted_reply_id')->nullable();
            }
            if (!Schema::hasColumn('topics', 'moderation_status')) {
                $table->string('moderation_status')->default('approved'); // approved, flagged_pending
            }
            if (!Schema::hasColumn('topics', 'flag_reason')) {
                $table->string('flag_reason')->nullable();
            }
        });

        // 3. Upgrade Replies Table for Moderation
        Schema::table('replies', function (Blueprint $table) {
            if (!Schema::hasColumn('replies', 'moderation_status')) {
                $table->string('moderation_status')->default('approved'); // approved, flagged_pending
            }
            if (!Schema::hasColumn('replies', 'flag_reason')) {
                $table->string('flag_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'warnings_count', 'blacklist_until', 'rules_accepted_at', 'last_active_at']);
        });
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn(['is_resolved', 'accepted_reply_id', 'moderation_status', 'flag_reason']);
        });
        Schema::table('replies', function (Blueprint $table) {
            $table->dropColumn(['moderation_status', 'flag_reason']);
        });
    }
};