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
        Schema::create('invoice_order', function (Blueprint $table) {
            $table->id(); // Add this line to have an auto-incrementing primary key
            $table->unsignedBigInteger('invoice_id'); // Changed to match the invoices table
            $table->decimal('product_cost', 8, 2)->nullable(); // Increased decimal precision
            $table->unsignedBigInteger('product_id');
            $table->decimal('quantity', 7, 2)->default(0.00);

            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('restrict');
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
