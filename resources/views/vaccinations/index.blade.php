<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予防接種記録一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">予防接種記録一覧</h1>

    {{-- 成功メッセージ --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 新規登録ボタン --}}
    <a href="{{ route('vaccinations.create') }}" class="btn btn-primary mb-3">新規登録</a>
    <a href="{{ route('baby_records.index') }}" class="btn btn-secondary mb-3">育児記録一覧に戻る</a>

    {{-- 記録がない場合 --}}
    @if($vaccinations->isEmpty())
        <div class="alert alert-info">予防接種記録がありません。</div>
    @else
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>お子さん</th>
                    <th>ワクチン名</th>
                    <th>回数</th>
                    <th>接種日</th>
                    <th>次回予定日</th>
                    <th>接種医療機関</th>
                    <th>備考</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vaccinations as $vaccination)
                <tr>
                    {{-- お子さんのアイコンと名前 --}}
                    <td>
                        @if($vaccination->child)
                            {{ $vaccination->child->default_icon }} {{ $vaccination->child->name }}
                        @else
                            <span class="text-muted">未設定</span>
                        @endif
                    </td>
                    <td>{{ $vaccination->vaccine_name }}</td>
                    <td>{{ $vaccination->dose_number }}回目</td>
                    <td>{{ $vaccination->vaccinated_at }}</td>
                    {{-- 次回予定日がない場合は「-」を表示 --}}
                    <td>{{ $vaccination->next_due_at ?? '-' }}</td>
                    <td>{{ $vaccination->clinic_name ?? '-' }}</td>
                    <td>{{ $vaccination->memo ?? '-' }}</td>
                    <td>
                        <a href="{{ route('vaccinations.edit', $vaccination) }}" class="btn btn-sm btn-warning">編集</a>
                        <form action="{{ route('vaccinations.destroy', $vaccination) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>