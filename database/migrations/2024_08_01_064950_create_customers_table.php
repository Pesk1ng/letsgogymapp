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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->string('fullname');
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
            $table->string('phoneNumber')->unique();
            $table->foreignId('customer_create_by')->constrained('users');
            $table->string('customer_creator_name');
            $table->foreignId('fitness_center_id')->constrained('fitness_centers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
