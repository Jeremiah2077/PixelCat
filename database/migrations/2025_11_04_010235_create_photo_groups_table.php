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
        Schema::create('photo_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // 分组名称：仪式、宴会、合影等
            $table->string('slug')->nullable(); // URL友好的标识
            $table->text('description')->nullable(); // 分组描述
            $table->string('icon')->nullable(); // 图标（emoji或heroicon名称）
            $table->string('color')->default('#3b82f6'); // 分组颜色
            $table->integer('sort_order')->default(0); // 排序
            $table->timestamps();

            $table->index('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_groups');
    }
};
