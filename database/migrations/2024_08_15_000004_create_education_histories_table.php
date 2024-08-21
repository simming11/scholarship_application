<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('education_histories', function (Blueprint $table) {
            $table->id('HistoriesId'); // Primary key with a custom column name
            $table->string('EducationLevel');
            $table->year('AcademicYear');
            $table->float('GPA', 3, 2);
            $table->string('AdvisorName', 100);
            $table->string('CourseName', 100);
            $table->string('ApplicationID', 15); // Foreign key column
            $table->timestamps();
            
            // Foreign key references
            $table->foreign('ApplicationID')->references('ApplicationID')->on('application_internals')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('education_histories');
    }
};
