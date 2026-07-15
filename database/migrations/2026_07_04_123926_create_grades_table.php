<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('grades', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
        $table->string('assessment_name'); // e.g., "Participation Marks", "Quiz #1"
        $table->decimal('score', 5, 2); // e.g., 88.00
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
