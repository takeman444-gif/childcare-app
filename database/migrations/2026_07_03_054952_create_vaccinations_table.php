<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained()->onDelete('cascade'); // どの子供の記録か（子供削除で記録も削除）
            $table->string('vaccine_name', 100);                               // ワクチン名
            $table->integer('dose_number')->default(1);                        // 何回目の接種か
            $table->date('vaccinated_at');                                     // 接種日
            $table->date('next_due_at')->nullable();                           // 次回予定日（任意）
            $table->string('manufacturer', 100)->nullable();                   // メーカー名（任意）
            $table->string('lot_number', 50)->nullable();                      // ロット番号（任意）
            $table->string('clinic_name', 100)->nullable();                    // 接種医療機関（任意）
            $table->text('memo')->nullable();                                  // 備考（任意）
            $table->timestamps();
            $table->softDeletes();                                             // 論理削除用
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};