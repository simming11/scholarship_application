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
        Schema::create('siblings', function (Blueprint $table) {
            $table->id('siblingsID'); // Primary key
            $table->string('PrefixName', 10); // คำนำหน้า
            $table->string('Fname', 50); // ชื่อ
            $table->string('Lname', 50); // นามสกุล
            $table->string('Occupation', 100)->nullable(); // อาชีพ
            $table->string('EducationLevel', 100)->nullable(); // ระดับการศึกษา
            $table->decimal('Income', 10, 2)->nullable(); // รายได้
            $table->enum('Status', ['สมรส', 'โสด']); // สถานภาพ
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
        Schema::dropIfExists('siblings');
    }
};
