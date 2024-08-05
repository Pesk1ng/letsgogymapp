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
        Schema::create('contract_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('contracts');
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('customer_name');
            $table->foreignId('user_id')->constrained('users'); // The user making the sale
            $table->string('user_name');
            $table->foreignId('contract_fitness_center_id')->constrained('fitness_centers');
            $table->foreignId('user_fitness_center_id')->constrained('fitness_centers');
            $table->integer('quantity_sold');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_sales');
    }
};
