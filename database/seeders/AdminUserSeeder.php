<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 既存のユーザーを管理者に設定（メールアドレスを自分のものに変更）
        User::where('email', 'admin@gmail.com')
            ->update(['is_admin' => true]);
    }
}