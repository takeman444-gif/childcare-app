<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>育児記録カレンダー</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* カレンダー全体のテーブル設定 */
        .calendar-table { width: 100%; table-layout: fixed; }

        /* 日付セルの設定 */
        .calendar-table td {
            height: 100px;
            vertical-align: top;
            padding: 6px;
            border: 1px solid #dee2e6;
        }

        /* 記録がある日はクリックできるようにカーソルを変える */
        .has-record { background-color: #f1f8e9; cursor: pointer; }
        .has-record:hover { background-color: #dcedc8; }

        /* 今日の日付を緑でハイライト */
        .today { border: 2px solid #66bb6a !important; }

        /* 記録件数バッジ */
        .record-badge {
            background-color: #66bb6a;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }

        /* 当月以外の日付は薄く表示 */
        .other-month { background-color: #f8f9fa; color: #ccc; }
    </style>
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">育児記録カレンダー</h1>

    {{-- 前月・次月のナビゲーション --}}
    <div class="d-flex align-items-center mb-3 gap-3">
        {{-- 前月ボタン --}}
        <a href="{{ route('baby_records.calendar', ['month' => $month->copy()->subMonth()->format('Y-m')]) }}"
           class="btn btn-outline-secondary">＜ 前月</a>

        {{-- 現在表示中の年月 --}}
        <h4 class="mb-0">{{ $month->format('Y年n月') }}</h4>

        {{-- 次月ボタン --}}
        <a href="{{ route('baby_records.calendar', ['month' => $month->copy()->addMonth()->format('Y-m')]) }}"
           class="btn btn-outline-secondary">次月 ＞</a>
    </div>

    {{-- カレンダー本体 --}}
    <table class="calendar-table">
        {{-- 曜日ヘッダー --}}
        <thead>
            <tr>
                @foreach(['日', '月', '火', '水', '木', '金', '土'] as $day)
                    <th class="text-center p-2 bg-white border">{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <?php
                // 月の最初の日と最後の日を取得
                $startOfMonth = $month->copy()->startOfMonth();
                $endOfMonth   = $month->copy()->endOfMonth();

                // カレンダーの開始日（月初の週の日曜日）
                $startDate = $startOfMonth->copy()->startOfWeek(Carbon\Carbon::SUNDAY);

                // カレンダーの終了日（月末の週の土曜日）
                $endDate = $endOfMonth->copy()->endOfWeek(Carbon\Carbon::SATURDAY);

                // 現在の日付
                $today = Carbon\Carbon::today()->format('Y-m-d');

                // 表示する日付をループ
                $current = $startDate->copy();
            ?>

            @while($current <= $endDate)
                {{-- 週の始まりで行を開始 --}}
                @if($current->dayOfWeek === Carbon\Carbon::SUNDAY)
                    <tr>
                @endif

                <?php
                    $dateStr     = $current->format('Y-m-d');
                    $isThisMonth = $current->month === $month->month;
                    $isToday     = $dateStr === $today;
                    $hasRecord   = isset($records[$dateStr]);
                    $recordCount = $hasRecord ? count($records[$dateStr]) : 0;
                ?>

                {{-- 日付セル --}}
                <td class="
                    {{ !$isThisMonth ? 'other-month' : '' }}
                    {{ $hasRecord ? 'has-record' : '' }}
                    {{ $isToday ? 'today' : '' }}"
                    {{-- 記録がある日はクリックで日別一覧へ --}}
                    @if($hasRecord)
                        onclick="window.location.href='{{ route('baby_records.daily', ['date' => $dateStr]) }}'"
                    @endif>

                    {{-- 日付の数字 --}}
                    <div class="fw-bold">{{ $current->day }}</div>

                    {{-- 記録件数バッジ --}}
                    @if($hasRecord)
                        <div class="mt-1">
                            <span class="record-badge">{{ $recordCount }}</span>
                            <span style="font-size: 0.75rem; color: #4a7c59;">件</span>
                        </div>
                    @endif
                </td>

                {{-- 週の終わりで行を閉じる --}}
                @if($current->dayOfWeek === Carbon\Carbon::SATURDAY)
                    </tr>
                @endif

                <?php $current->addDay(); ?>
            @endwhile
        </tbody>
    </table>

    <div class="mt-3">
        <a href="{{ route('baby_records.index') }}" class="btn btn-secondary">一覧に戻る</a>
    </div>
</div>
</body>
</html>