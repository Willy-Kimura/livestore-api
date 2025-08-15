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
            $table->foreignId('brand_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('name')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('long_desc')->nullable();
            $table->decimal('regular_price', places:2)->nullable();
            $table->decimal('sale_price', places:2)->nullable();
            $table->enum('status', ['In Stock', 'Out of Stock', 'Pre-order', 'Backorder', 'Discontinued'])->default('In Stock')->nullable();
            $table->enum('attribute', ['Size', 'Weight', 'Material', 'Color', 'Dimensions', 'Consumable', 'Service'])->nullable();
            $table->enum('unit', ['m', 'cm', 'mm', 'kg', 'g', 'mg', 'l', 'ml', 'piece', 'dozen'])->nullable();
            $table->integer('rating')->nullable();
            $table->boolean('allow_reviews')->default(true);
            $table->json('images')->nullable();
            $table->text('tags')->nullable();
            $table->integer('stock')->default(5000);
            $table->integer('low_stock')->default(5);
            $table->boolean('is_free')->default(false);
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
