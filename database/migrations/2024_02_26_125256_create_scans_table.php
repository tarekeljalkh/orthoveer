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
        Schema::create('scans', function (Blueprint $table) {
            //$table->id();
            // Modify the line below to set the starting value to 1000
            $table->bigIncrements('id')->startingValue(10000000); // Set the starting value to 1000
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->unsignedBigInteger('lab_id')->nullable();
            $table->foreign('lab_id')->references('id')->on('users');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->date('due_date')->format('d/m/Y');
            $table->date('scan_date')->format('d/m/Y');
            $table->string('stl_upper')->nullable();
            $table->string('stl_lower')->nullable();
            $table->string('pdf')->nullable();
            $table->string('practitioner')->nullable();
            $table->string('cabinet')->nullable();
            $table->string('procedure')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // Set the starting value for the primary key (id) to 1000
        //\DB::statement('ALTER TABLE users AUTO_INCREMENT = 1000');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scans');
    }
};
