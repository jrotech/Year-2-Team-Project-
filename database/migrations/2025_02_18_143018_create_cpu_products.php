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
    public function up()
    {
        Schema::create('cpu_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->unique();
            

            // CPU-specific fields
            $table->string('socket_type')->nullable();
            $table->integer('tdp')->nullable();
            $table->boolean('integrated_graphics')->default(false);

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cpu_products');
    }
};