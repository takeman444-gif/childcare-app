<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $date->format('Y年n月j日') }}の記録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">

    {{-- タイトルに日付を表示 --}}
    <h1 class="mb-4">{{ $date->format('Y年n月j日') }}の記録</h1>

    {{-- 記録が1件もない場合 --}}
    @if($records->isEmpty())
        <div class="alert alert-info">この日の記録はありません。</div>
    @else
        {{-- 記録一覧をカード形式で表示 --}}
        @foreach($records as $record)
            <div class="card mb-3">
                <div class="card-body">

                    {{-- 種別とアイコン --}}
                    <h5 class="card-title">
                        @if($record->category === '授乳') 🍼
                        @elseif($record->category === '睡眠') 😴
                        @elseif($record->category === '排泄') 🚼
                        @else 📝
                        @endif
                        {{ $record->category }}
                    </h5>

                    {{-- 記録日時 --}}
                    <p class="text-muted" style="font-size: 0.85rem;">
                        {{ \Carbon\Carbon::parse($record->recorded_at)->format('H:i') }}
                    </p>

                    {{-- メモ --}}
                    @if($record->memo)
                        <p class="card-text">{{ $record->memo }}</p>
                    @endif

                    {{-- 画像 --}}
                    @if($record->image_path)
                        <img src="{{ asset('storage/' . $record->image_path) }}" width="200" class="rounded">
                    @endif

                    {{-- 編集・削除ボタン --}}
                    <div class="mt-2">
                        <a href="{{ route('baby_records.edit', $record) }}" class="btn btn-sm btn-warning">編集</a>
                        <form action="{{ route('baby_records.destroy', $record) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('削除しますか？')">削除</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- カレンダーに戻るボタン --}}
    <a href="{{ route('baby_records.calendar', ['month' => $date->format('Y-m')]) }}" class="btn btn-secondary">カレンダーに戻る</a>

</div>
</body>
</html>