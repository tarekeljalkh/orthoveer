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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->date('scan_date')->format('d/m/Y');
            $table->string('order_id');
            $table->string('patient_name');
            $table->string('practitioner');
            $table->string('cabinet');
            $table->string('procedure');
            $table->date('due_date')->format('d/m/Y');
            $table->enum('status', ['pending', 'return', 'done']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
