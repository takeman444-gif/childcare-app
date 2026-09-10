<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">ユーザー管理</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ユーザー一覧 --}}
    <h4 class="mb-3">ユーザー一覧</h4>
    <table class="table table-bordered table-hover bg-white mb-5">
        <thead class="table-dark">
            <tr>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>権限</th>
                <th>登録日</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->is_admin)
                        <span class="badge bg-danger">管理者</span>
                    @else
                        <span class="badge bg-secondary">一般ユーザー</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('Y/m/d') }}</td>
                <td>
                    {{-- 自分自身は変更不可 --}}
                    @if($user->id !== Auth::id())
                        <form action="{{ route('admin.toggleAdmin', $user) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $user->is_admin ? 'btn-warning' : 'btn-success' }}">
                                {{ $user->is_admin ? '権限を剥奪' : '管理者にする' }}
                            </button>
                        </form>
                    @else
                        <span class="text-muted">（自分）</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 新規ユーザー追加フォーム --}}
    <h4 class="mb-3">新規ユーザー追加</h4>
    <div class="card p-4 bg-white" style="border-radius: 15px; border: 1px solid #c8e6c9;">
        <form action="{{ route('admin.storeUser') }}" method="POST">
            @csrf

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 名前 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">名前</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            {{-- メールアドレス --}}
            <div class="mb-3">
                <label class="form-label fw-bold">メールアドレス</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            {{-- パスワード --}}
            <div class="mb-3">
                <label class="form-label fw-bold">パスワード（8文字以上）</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            {{-- 管理者フラグ --}}
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_admin" value="1" class="form-check-input" id="is_admin">
                    <label class="form-check-label" for="is_admin">管理者権限を付与する</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">ユーザーを追加する</button>
        </form>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">ダッシュボードに戻る</a>
    </div>
</div>
</body>
</html>