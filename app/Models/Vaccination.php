<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaccination extends Model
{
    use SoftDeletes; // 論理削除を有効化

    protected $fillable = [
        'child_id',      // どの子供の記録か
        'vaccine_name',  // ワクチン名
        'dose_number',   // 何回目の接種か
        'vaccinated_at', // 接種日
        'next_due_at',   // 次回予定日
        'manufacturer',  // メーカー名
        'lot_number',    // ロット番号
        'clinic_name',   // 接種医療機関
        'memo',          // 備考
    ];

    // この記録が紐づく子供との関係
    // Vaccination は1人のChildに属する
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}

