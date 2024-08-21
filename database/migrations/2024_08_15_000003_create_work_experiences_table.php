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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id('WorkexperiencesId'); // Primary key (auto-incrementing)
            $table->string('Name'); // Name of the job
            $table->string('JobType'); // Type of job or nature of the work
            $table->string('Duration'); // Duration of work, e.g., "3 months", "7 days"
            $table->decimal('Earnings', 10, 2); // Earnings received, with 2 decimal places
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
        Schema::dropIfExists('work_experiences');
    }
};
