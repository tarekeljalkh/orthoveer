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
            //$table->id();
            // Modify the line below to set the starting value to 1000
            $table->bigIncrements('id')->startingValue(10000000); // Set the starting value to 1000
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->text('image')->default('uploads/avatar.png');
            $table->string('mobile')->unique()->nullable();
            $table->string('landline')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('siret_number')->nullable();
            $table->enum('role', ['super_admin', 'admin', 'doctor', 'lab', 'external_lab'])->default('doctor');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Set the starting value for the primary key (id) to 1000
        //\DB::statement('ALTER TABLE users AUTO_INCREMENT = 1000');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
