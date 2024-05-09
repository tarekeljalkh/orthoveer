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
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('lab_id')->nullable();
            $table->foreign('lab_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('second_lab_id')->nullable();
            $table->foreign('second_lab_id')->references('id')->on('users')->onDelete('cascade');
            // Adding a field for lab reassignment
            $table->unsignedBigInteger('external_lab_id')->nullable();
            $table->foreign('external_lab_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('typeof_works')->onDelete('cascade');
            $table->date('due_date')->format('d/m/Y');
            $table->date('scan_date')->format('d/m/Y');
            $table->string('stl_upper')->nullable();
            $table->string('stl_lower')->nullable();
            $table->string('pdf')->nullable();
            $table->string('lab_file')->nullable();
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
