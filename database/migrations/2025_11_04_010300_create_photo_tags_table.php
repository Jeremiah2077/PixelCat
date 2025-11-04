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
        Schema::create('photo_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // 标签名称：新郎、新娘、家人、朋友等
            $table->string('slug')->nullable();
            $table->string('color')->default('#10b981'); // 标签颜色
            $table->timestamps();

            $table->index('project_id');
        });

        // 照片-标签多对多关联表
        Schema::create('photo_photo_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('photo_tag_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['photo_id', 'photo_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_photo_tag');
        Schema::dropIfExists('photo_tags');
    }
};
