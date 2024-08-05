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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 35);
            $table->decimal('product_price', 7, 0);
            $table->decimal('product_stock', 5, 0)->nullable();
            $table->string('product_description', 250);
            $table->foreignId('product_create_by')->constrained('users');
            $table->string('product_creator_name');
            $table->foreignId('fitness_center_id')->constrained('fitness_centers')->onDelete('cascade');
            $table->foreignId('product_category_id')->constrained('product_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
