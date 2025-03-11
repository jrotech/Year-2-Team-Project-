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
    //run the migrations
    public function up(): void
    {
        Schema::create('psu_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id')->unique();
            $table->integer('power');

            $table->timestamps();
            $table->foreign('product_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade');
        });
    }

     // Reverse the migrations.
     
    public function down(): void
    {
        Schema::dropIfExists('psu_products');
    }
};