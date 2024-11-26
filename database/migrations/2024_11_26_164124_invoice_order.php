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
        Schema::create('invoice_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_number'); // Foreign key to invoices table
            $table->unsignedBigInteger('product_id'); // Foreign key to products table
            $table->decimal('product_cost', 5, 2); // Cost of the product
            $table->decimal('quantity', 7, 2); // Quantity of the product ordered
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('invoice_number')->references('invoice_number')->on('invoices')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Primary key
            $table->primary(['invoice_number', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_orders');
    }
};
