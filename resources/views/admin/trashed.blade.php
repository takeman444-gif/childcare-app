<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>削除済み記録の管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">削除済み記録の管理</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($records->isEmpty())
        <div class="alert alert-info">削除済みの記録はありません。</div>
    @else
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>お子さん</th>
                    <th>種別</th>
                    <th>メモ</th>
                    <th>記録日時</th>
                    <th>削除日時</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td>
                        @if($record->child)
                            {{ $record->child->default_icon }} {{ $record->child->name }}
                        @else
                            <span class="text-muted">未設定</span>
                        @endif
                    </td>
                    <td>{{ $record->category }}</td>
                    <td>{{ $record->memo }}</td>
                    <td>{{ $record->recorded_at }}</td>
                    <td>{{ $record->deleted_at }}</td>
                    <td>
                        {{-- 復元ボタン --}}
                        <form action="{{ route('admin.restore', $record->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">復元</button>
                        </form>

                        {{-- 完全削除ボタン --}}
                        <form action="{{ route('admin.forceDelete', $record->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('完全に削除しますか？元に戻せません。')">完全削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('admin.index') }}" class="btn btn-secondary">ダッシュボードに戻る</a>
</div>
</body>
</html>
