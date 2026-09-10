<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>育児記録一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">育児記録一覧</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('baby_records.create') }}" class="btn btn-primary mb-3">新規登録</a>
    <a href="{{ route('baby_records.calendar') }}" class="btn btn-success mb-3">カレンダー</a>
    <a href="{{ route('vaccinations.index') }}" class="btn btn-info mb-3">💉 予防接種記録</a>

    <a href="{{ route('children.index') }}" class="btn btn-outline-secondary mb-3">マイページ</a>
    
    {{-- 管理者の場合のみ管理者ダッシュボードボタンを表示 --}}
    @if(Auth::user()->is_admin)
        <a href="{{ route('admin.index') }}" class="btn btn-danger mb-3">管理者ダッシュボード</a>
    @endif

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>名前</th>
                <th>写真</th>
                <th>種別</th>
                <th>メモ</th>
                <th>記録日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                {{-- お子さんのプロフィール画像と名前 --}}
                <td class="text-center">
                    @if($record->child)
                        @if($record->child->image_path)
                            <img src="{{ asset('storage/' . $record->child->image_path) }}"
                                width="40" height="40"
                                style="border-radius: 50%; object-fit: cover;">
                        @else
                            <span style="font-size: 1.5rem;">{{ $record->child->default_icon }}</span>
                        @endif
                        <div style="font-size: 0.8rem;">{{ $record->child->name }}</div>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>

                {{-- 育児記録の写真 --}}
                <td>
                    @if($record->image_path)
                        <img src="{{ asset('storage/' . $record->image_path) }}" width="80">
                    @else
                        <span class="text-muted">なし</span>
                    @endif
                </td>

                <td>{{ $record->category }}</td>
                <td>{{ $record->memo }}</td>
                <td>{{ $record->recorded_at }}</td>
                <td>
                    <a href="{{ route('baby_records.edit', $record) }}" class="btn btn-sm btn-warning">編集</a>
                    <form action="{{ route('baby_records.destroy', $record) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('削除しますか？')">削除</button>
                    </form>
                </td>
            </tr>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>