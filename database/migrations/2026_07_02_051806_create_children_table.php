<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // どのユーザーの子供か（ユーザー削除で子供も削除）
            $table->string('name');                    // 子供の名前
            $table->enum('gender', ['boy', 'girl']);   // 性別（boy or girl）
            $table->date('birthday')->nullable();      // 生年月日（任意）
            $table->date('due_date')->nullable();      // 出産予定日（任意）
            $table->string('image_path')->nullable();  // プロフィール画像（任意）
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};