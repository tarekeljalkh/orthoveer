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
        Schema::create('typeof_works', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('lab_price')->nullable();
            $table->double('bag_coule')->nullable();
            $table->double('my_price')->nullable();
            $table->double('invoice_to')->nullable();
            $table->double('cash_out')->nullable();
            $table->double('my_benefit')->nullable();
            $table->double('accessories')->nullable();
            $table->unsignedBigInteger('lab_id');
            $table->foreign('lab_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typeof_works');
    }
};
