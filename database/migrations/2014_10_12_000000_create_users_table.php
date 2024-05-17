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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('image')->default('uploads/avatar.png')->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->string('landline')->nullable();
            $table->string('license')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('siret_number')->nullable();
            $table->enum('role', ['admin', 'doctor', 'lab', 'second_lab', 'external_lab'])->default('doctor');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
