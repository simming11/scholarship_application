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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id('GuardiansID'); // Primary key
            $table->string('FirstName', 50); // ชื่อ
            $table->string('LastName', 50); // นามสกุล
            $table->enum('Type', ['พ่อ', 'แม่', 'ผู้อุปการะ']); // ประเภท มี พ่อ, แม่, ผู้อุปการะ
            $table->string('Occupation', 100)->nullable(); // อาชีพ
            $table->decimal('Income', 10, 2)->nullable(); // รายได้
            $table->integer('Age')->nullable(); // อายุ
            $table->enum('Status', ['มีชีวิต', 'ไม่มีชีวิต']); // สถานภาพ
            $table->string('Workplace', 100)->nullable(); // สถานที่ทำงาน
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
        Schema::dropIfExists('guardians');
    }
};
