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
            $table->id();
            $table->unsignedBigInteger('lab_id'); // ID of the lab or user creating the order
            $table->foreign('lab_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('admin_id'); // ID of the admin to handle the order
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('dhl_tracking_number')->nullable(); // DHL tracking number
            $table->string('status'); // Order status, e.g., pending, shipped, completed
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
