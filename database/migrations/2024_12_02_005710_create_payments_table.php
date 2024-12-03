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
    Schema::create('payments', function (Blueprint $table) {
        $table->increments('id');
        $table->date('date');
        $table->integer('invoice_number')->unsigned();
        $table->integer('customer_id')->unsigned();
        $table->integer('transaction_id');
        $table->dateTime('deleted')->nullable();
        $table->timestamps();

        $table->foreign('invoice_number')->references('invoice_number')->on('invoices')->onDelete('cascade');
        $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
