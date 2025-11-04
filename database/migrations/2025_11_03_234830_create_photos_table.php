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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('file_path');
            $table->string('thumbnail_path')->nullable();
            $table->string('original_name');
            $table->integer('file_size');
            $table->string('mime_type');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('order')->default(0);
            $table->integer('download_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
