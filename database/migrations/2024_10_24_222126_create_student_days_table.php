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
    Schema::create('student_days', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('student_id');
        $table->unsignedBigInteger('day_id');
        $table->boolean('is_mandatory')->default(0); // Hari wajib seperti Jumat
        $table->timestamps();

        // Foreign keys
        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
    });
}




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_days');
    }
};
