<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('status', 20)->default('pending'); // status: pending, paid
            $table->unsignedBigInteger('customer_id'); // foreign key -> customers table
            $table->unsignedBigInteger('invoice_number', 50)->autoIncrement();
            $table->date(column: 'paid_date')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('due_date')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->primary(['invoice_number']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};