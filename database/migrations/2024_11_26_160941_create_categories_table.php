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
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name', 20);
            $table->text('description')->nullable();
            $table->string('image')->nullable(); 
            $table->integer('delete'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};