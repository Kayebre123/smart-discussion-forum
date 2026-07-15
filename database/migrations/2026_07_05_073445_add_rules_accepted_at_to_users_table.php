<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            if (!Schema::hasColumn('users', 'rules_accepted_at')) {
                $blueprint->timestamp('rules_accepted_at')->nullable()->default(null);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            $blueprint->dropColumn('rules_accepted_at');
        });
    }
};