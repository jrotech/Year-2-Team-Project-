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
            $table->increments('id'); // Primary key
            $table->string('name', 50);
            $table->decimal('price', 10, 2);
            $table->string('description', 10000);
            $table->boolean('in_stock');
            $table->tinyInteger('deleted')->default(0); // For soft deletes or inactive products
            $table->timestamps();
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