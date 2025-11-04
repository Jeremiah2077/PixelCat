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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photographer_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->date('project_date');
            $table->string('location')->nullable();
            $table->string('client_name');
            $table->text('notes')->nullable();
            $table->enum('status', ['in_progress', 'delivered'])->default('in_progress');
            $table->string('share_token')->unique();
            $table->boolean('allow_download')->default(true);
            $table->integer('view_count')->default(0);
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
