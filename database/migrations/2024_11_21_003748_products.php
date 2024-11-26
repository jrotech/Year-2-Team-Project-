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
        //
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Product name (varchar 20)
            $table->decimal('price', 5, 2)->default(0.00); // Price (decimal 5,2)
            $table->text('description', 255)->nullable(); // Description (varchar 255, nullable)
            $table->boolean('in_stock')->default(true); // In-stock status (tinyint as boolean)
            $table->dateTime('deleted', 6)->nullable(); // Deleted datetime with precision
            $table->integer("stock");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('products');
    }
};
