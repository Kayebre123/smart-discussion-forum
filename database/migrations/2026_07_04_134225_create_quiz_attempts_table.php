<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The student taking the quiz
            $table->integer('score'); // Calculated final score percentage
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_attempts');
    }
};