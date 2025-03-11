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
        Schema::create('Socket_Details', function (Blueprint $table) {
            $table->id();
            $table->string('Socket');
            $table->timestamps();
        });
    }

     // Reverse the migrations.
     
    public function down(): void
    {
        Schema::dropIfExists('Socket_Details');
    }
};