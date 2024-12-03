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
    Schema::create('delivery', function (Blueprint $table) {
        $table->date('date');
        $table->integer('invoice_number')->unsigned();
        $table->decimal('delivery_cost', 5, 2);
        $table->tinyInteger('status');
        $table->string('postcode', 8);
        $table->string('street', 50);
        $table->string('city', 20);
        $table->timestamps();

        $table->foreign('invoice_number')->references('invoice_number')->on('invoices')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery');
    }
};
