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
            $table->string('status'); // Order status, e.g., pending, shipped, completed
            $table->dateTime('date');
            $table->string('to_name');
            $table->string('destination_street');
            $table->string('destination_suburb')->nullable();
            $table->string('destination_city');
            $table->string('destination_postcode');
            $table->string('destination_state');
            $table->string('destination_country');
            $table->string('destination_email')->nullable();
            $table->string('destination_phone');
            $table->string('item_name')->nullable();
            $table->decimal('item_price', 8, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('reference')->nullable();
            $table->string('sku')->nullable();
            $table->integer('qty')->nullable();
            $table->string('company')->nullable();
            $table->string('carrier')->nullable();
            $table->string('carrier_product_code')->nullable();
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
