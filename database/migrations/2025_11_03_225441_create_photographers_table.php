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
        Schema::create('photographers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('brand_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photographers');
    }
};
