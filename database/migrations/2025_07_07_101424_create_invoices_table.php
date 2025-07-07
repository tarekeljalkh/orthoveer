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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            // The user who created the invoice (admin, doctor, lab, etc.)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');

            // Invoice fields
            $table->string('invoice_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('unpaid');
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('pdf_path')->nullable(); // Optional: PDF storage path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
