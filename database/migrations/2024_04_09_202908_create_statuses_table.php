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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scan_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['new', 'downloaded', 'pending', 'completed', 'rejected', 'resubmitted', 'delivered'])->default('new');
            $table->text('note')->nullable(); // Optional, for storing the reason for the status change
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null'); // Optional, to track who updated the status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
