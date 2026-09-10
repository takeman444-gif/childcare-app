<<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baby_records', function (Blueprint $table) {
            // どの子供の記録かを紐づける外部キー
            // nullable()にすることで既存データが壊れないようにする
            // nullableを先に書いてからconstrained()を書く必要がある
            $table->foreignId('child_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('baby_records', function (Blueprint $table) {
            // 外部キー制約を先に削除してからカラムを削除する
            $table->dropForeign(['child_id']);
            $table->dropColumn('child_id');
        });
    }
};