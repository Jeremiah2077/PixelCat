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
        Schema::table('photos', function (Blueprint $table) {
            $table->boolean('is_favorite')->default(false)->after('order'); // 是否精选
            $table->foreignId('photo_group_id')->nullable()->after('is_favorite')->constrained()->nullOnDelete(); // 所属分组

            $table->index('is_favorite');
            $table->index('photo_group_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropForeign(['photo_group_id']);
            $table->dropIndex(['is_favorite']);
            $table->dropIndex(['photo_group_id']);
            $table->dropColumn(['is_favorite', 'photo_group_id']);
        });
    }
};
