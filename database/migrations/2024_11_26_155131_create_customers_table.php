<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('customer_name', 100);
            $table->string('password');
            $table->string('phone_number', 15)->nullable();
            $table->string('email', 100)->unique();
            $table->boolean('email_confirmed')->default(false);
            $table->decimal('prev_balance', 10, 2)->default(0.00); // outstanding balance
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
