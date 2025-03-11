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
        Schema::create('storage_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->unique();
            $table->string('connector_type')->nullable();
            
            $table->timestamps();

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('storage_products');
    }
};