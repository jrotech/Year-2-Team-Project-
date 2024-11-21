<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('customer_name', 50); // Customer name (varchar 50)
                $table->string('email', 50)->nullable(); // Email (varchar 50, nullable)
                $table->string('phone_number', 11)->nullable(); // Phone number (varchar 11, nullable)
                $table->boolean('email_confirmed')->default(false); // Email confirmed (tinyint as boolean)
                $table->decimal('prev_balance', 8, 2)->default(0.00); // Previous balance (decimal 8,2)
                $table->dateTime('deleted', 6)->nullable(); // Deleted datetime with precision
                $table->string('password'); // Password (varchar 50)
                $table->timestamps(); // Adds `created_at` and `updated_at`

        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
