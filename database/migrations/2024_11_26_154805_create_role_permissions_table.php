<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('role_id'); // Foreign key to roles table
            $table->string('table_name', 50); // Name of the resource
            $table->boolean('read')->default(false); // Read permission
            $table->boolean('write')->default(false); // Write permission
            $table->boolean('delete')->default(false); // Delete permission
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
}; 