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
        Schema::create('CPU_Details', function (Blueprint $table) {
            $table->id();
            $table->string('Socket_Type');
            $table->int('Power');
            $table->boolean('HasGraphics');
            $table->string('Channel');
            $table->timestamps();
        });
    }

     // Reverse the migrations.
     
    public function down(): void
    {
        Schema::dropIfExists('CPU_Details');
    }
};