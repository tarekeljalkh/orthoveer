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
            $table->double('my_price')->nullable();
            $table->double('cash_out')->nullable();
            $table->double('my_benefit')->nullable();
            $table->double('accessories')->nullable();
            $table->double('vat')->nullable();
            $table->unsignedBigInteger('lab_id');
            $table->foreign('lab_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('lab_due_date')->nullable();
            $table->unsignedBigInteger('second_lab_id')->nullable(); // make nullable
            $table->foreign('second_lab_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('second_lab_due_date')->nullable();
            $table->unsignedBigInteger('external_lab_id')->nullable(); // make nullable
            $table->foreign('external_lab_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('external_lab_due_date')->nullable();
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
