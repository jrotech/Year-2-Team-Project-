<?php
/********************************
Developer: Kai Lowe-Jones, Robert Oros
University ID: 230234682, 230237144
********************************/
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
        $table->unsignedBigInteger('invoice_id')->unsigned();
        $table->unsignedBigInteger('customer_id')->unsigned();
        $table->integer('transaction_id');
        $table->dateTime('deleted')->nullable();
        $table->timestamps();

        $table->foreign('invoice_id')->references('invoice_id')->on('invoices')->onDelete('cascade');
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
