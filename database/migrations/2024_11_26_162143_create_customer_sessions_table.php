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
        Schema::create('customer_sessions', function (Blueprint $table) {
            $table->id(); // primary key
            $table->timestamp(column: 'expires_at')->nullable(); // expiry date
            $table->unsignedBigInteger('customer_id'); // foreign key -> customers table
            $table->string('session_token')->unique();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('customer_sessions');
    }
};