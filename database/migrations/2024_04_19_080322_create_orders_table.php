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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lab_id'); // ID of the lab or user creating the order
            $table->foreign('lab_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('scan_id');
            $table->string('name')->nullable();
            $table->string('street')->nullable();
            $table->string('suburb')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->enum('status', ['pending', 'delivered'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
