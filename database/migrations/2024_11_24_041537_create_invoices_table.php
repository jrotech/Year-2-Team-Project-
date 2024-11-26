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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Add this line to have an auto-incrementing primary key
            $table->date('date');
            $table->unsignedBigInteger('customer_id'); // Changed to match Laravel's default ID type
            $table->integer('invoice_number')->unique(); // Changed from primary to unique
            $table->decimal('invoice_amount', 8, 2)->default(0.00);
            $table->enum('delivery_option', ['Delivery', 'Pick up'])->default('Delivery');
            $table->enum('status', [
                'Received',
                'Waiting For Delivery',
                'Waiting For Collection',
                'Cancelled',
                'Returned'
            ])->default('Waiting For Delivery');
            $table->softDeletes(); // Changed to use Laravel's softDeletes
            $table->timestamps();
            // Change this line to match your actual customer/user table
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers') // or 'users' depending on your table name
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
