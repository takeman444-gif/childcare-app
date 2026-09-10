<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者ダッシュボード</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">管理者ダッシュボード</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 統計情報 --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center p-3" style="border-color: #c8e6c9;">
                <h2 class="text-success">{{ $totalRecords }}</h2>
                <p class="text-muted mb-0">総記録件数</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3" style="border-color: #ffcdd2;">
                <h2 class="text-danger">{{ $trashedRecords }}</h2>
                <p class="text-muted mb-0">削除済み件数</p>
            </div>
        </div>
    </div>

        {{-- 機能ボタン --}}
        {{-- 機能ボタン --}}
    <div class="d-flex gap-3 flex-wrap">
        {{-- 削除済み記録の管理ボタン --}}
        <a href="{{ route('admin.trashed') }}" class="btn btn-warning">🗑 削除済み記録の管理</a>

        {{-- CSVエクスポートボタン --}}
        <a href="{{ route('admin.export') }}" class="btn btn-success">📥 CSVエクスポート</a>

        {{-- ユーザー管理ボタン --}}
        <a href="{{ route('admin.users') }}" class="btn btn-primary">👤 ユーザー管理</a>

        {{-- 育児記録一覧に戻るボタン --}}
        <a href="{{ route('baby_records.index') }}" class="btn btn-secondary">育児記録一覧に戻る</a>
    </div>
</div>
</body>
</html>