<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('basket_product', function (Blueprint $table) {
            $table->unsignedBigInteger('basket_id'); // Foreign key to the basket
            $table->unsignedInteger('product_id'); // Foreign key to the product
            $table->unsignedInteger('quantity'); // Quantity of the product in the basket
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('basket_id')->references('id')->on('baskets')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Composite primary key
            $table->primary(['basket_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basket_product');
    }
};
