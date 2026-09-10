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
        Schema::create('baby_records', function (Blueprint $table) {
            $table->id();
            $table->string('category', 50);      // 種別（授乳・睡眠・排泄など）
            $table->text('memo')->nullable();     // メモ・備考
            $table->dateTime('recorded_at');      // 記録日時（ユーザー指定）
            $table->timestamps();                 // created_at, updated_at
            $table->softDeletes();                // deleted_at（論理削除用）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baby_records');
    }
};
