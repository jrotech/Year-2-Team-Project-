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
        Schema::create('cooler_sockets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cooler_id');
            $table->string('socket_type')->nullable();
            
            $table->timestamps();

            $table->foreign('cooler_id')
                  ->references('id')
                  ->on('cooler_products')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cooler_sockets');
    }
};