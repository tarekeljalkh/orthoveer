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
        Schema::create('treatment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scan_id')->constrained()->onDelete('cascade');

            // doctor who created the plan (should match scan.doctor_id)
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');

            // external lab who processes the plan
            $table->foreignId('second_lab_id')->nullable()->constrained('users')->onDelete('set null');

            $table->text('notes')->nullable();
            $table->json('uploaded_files')->nullable(); // uploaded by doctor
            $table->string('external_stl_link')->nullable(); // STL returned by lab (web link)
            $table->enum('status', ['pending', 'in_progress', 'review', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_plans');
    }
};
