<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id'); // foreign key to roles table
            $table->rememberToken(); //remember me functionality
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void

    {
        Schema::dropIfExists('users');
    }
};