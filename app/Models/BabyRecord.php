<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BabyRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'child_id',   // どの子供の記録か
        'category',   // 種別（授乳・睡眠・排泄・その他）
        'memo',       // メモ・備考
        'image_path', // 添付画像
        'recorded_at', // 記録日時
    ];

    // この記録が紐づく子供との関係
    // BabyRecord は1人のChildに属する
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}