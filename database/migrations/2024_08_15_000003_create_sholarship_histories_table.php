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
        Schema::create('scholarship_histories', function (Blueprint $table) {
            $table->id('HistoriesID'); // Primary key
            $table->string('ScholarshipName', 100); // ชื่อทุนที่ได้รับ
            $table->decimal('AmountReceived', 10, 2); // จำนวนเงินที่ได้รับ
            $table->year('AcademicYear'); // ปีการศึกษา
            $table->string('ApplicationID', 15); // Foreign key column
            $table->timestamps(); // Adds created_at and updated_at columns

            // Foreign key references
            $table->foreign('ApplicationID')->references('ApplicationID')->on('application_internals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship_histories');
    }
};
