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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('price', 8, 2);
        $table->string('image')->nullable(); // Path to the product image
        $table->boolean('is_best_seller')->default(false);
        $table->unsignedBigInteger('category_id')->nullable();
        $table->timestamps();

        // Foreign key for category
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
