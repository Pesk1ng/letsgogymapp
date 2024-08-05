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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_name');
            $table->string('contract_code')->unique();
            $table->integer('contract_duration');
            $table->string('fitness_center_id');
            $table->foreignId('contract_create_by')->constrained('users');
            $table->string('contract_creator_name');
            $table->integer('contract_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
