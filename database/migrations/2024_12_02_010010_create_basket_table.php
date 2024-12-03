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
    Schema::create('basket', function (Blueprint $table) {
        $table->integer('invoice_number')->unsigned();
        $table->decimal('product_cost', 5, 2);
        $table->unsignedInteger('product_id')->unsigned();
        $table->decimal('quantity', 7, 2);
        $table->unsignedBigInteger('customer_id')->unsigned();
        $table->timestamps();

        $table->foreign('invoice_number')->references('invoice_number')->on('invoices')->onDelete('cascade');
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basket');
    }
};
