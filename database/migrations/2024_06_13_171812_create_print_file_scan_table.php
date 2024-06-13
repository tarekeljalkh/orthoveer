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
        Schema::create('print_file_scan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('print_file_id');
            $table->unsignedBigInteger('scan_id');

            $table->foreign('print_file_id')->references('id')->on('print_files')->onDelete('cascade');
            $table->foreign('scan_id')->references('id')->on('scans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('print_file_scan');
    }
};
