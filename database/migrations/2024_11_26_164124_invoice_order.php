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
    public function up(): void
    {
        Schema::create('invoice_orders', function (Blueprint $table) {
            $table->id(); // Add a single-column primary key
            $table->unsignedBigInteger('invoice_id'); // Foreign key to invoices table
            $table->unsignedInteger('product_id'); // Foreign key to products table
            $table->decimal('product_cost', 10, 2); // Cost of the product
            $table->integer('quantity'); // Quantity of the product ordered
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('invoice_id')
                ->references('invoice_id')
                ->on('invoices')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
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
