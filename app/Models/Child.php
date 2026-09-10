<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = [
        'user_id',    // どのユーザーの子供か
        'name',       // 名前
        'gender',     // 性別（boy/girl）
        'birthday',   // 生年月日
        'due_date',   // 出産予定日
        'image_path', // プロフィール画像
    ];

    // この子供を登録したユーザーとの関係
    // Child は1人のUserに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // この子供に紐づく育児記録との関係
    // Child は複数のBabyRecordを持つ
    public function babyRecords()
    {
        return $this->hasMany(BabyRecord::class);
    }

    // この子供に紐づく予防接種記録との関係
    // Child は複数の Vaccination を持つ
    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    // 性別に応じたデフォルトアイコンを返す
    // プロフィール画像がない場合に使用
    public function getDefaultIconAttribute()
    {
        return $this->gender === 'boy' ? '👦' : '👧';
    }
}