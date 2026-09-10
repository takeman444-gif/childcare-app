<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>育児記録アプリ｜新規登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 50%, #fafde7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Helvetica Neue', sans-serif;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(100, 150, 100, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .app-icon {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 8px;
        }

        .app-title {
            text-align: center;
            color: #4a7c59;
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .app-subtitle {
            text-align: center;
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 28px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #c8e6c9;
            padding: 10px 14px;
            background: #f9fdf9;
        }

        .form-control:focus {
            border-color: #66bb6a;
            box-shadow: 0 0 0 3px rgba(102, 187, 106, 0.15);
        }

        .form-label {
            color: #4a7c59;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .btn-register {
            background: linear-gradient(135deg, #66bb6a, #4caf50);
            border: none;
            border-radius: 10px;
            color: white;
            padding: 12px;
            font-size: 1rem;
            font-weight: bold;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #57a05a, #43a047);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .leaf {
            position: fixed;
            opacity: 0.07;
            font-size: 8rem;
            pointer-events: none;
        }

        .leaf-1 { top: 5%; left: 5%; transform: rotate(-20deg); }
        .leaf-2 { bottom: 5%; right: 5%; transform: rotate(30deg); }
        .leaf-3 { top: 40%; right: 8%; transform: rotate(-10deg); font-size: 5rem; }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #888;
        }

        .login-link a {
            color: #4a7c59;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    {{-- 背景の葉っぱ装飾 --}}
    <div class="leaf leaf-1">🌿</div>
    <div class="leaf leaf-2">🍃</div>
    <div class="leaf leaf-3">🌱</div>

    <div class="register-card">
        <div class="app-icon">🌱</div>
        <div class="app-title">育児記録アプリ</div>
        <div class="app-subtitle">アカウントを作成しよう</div>

        {{-- エラーメッセージ --}}
        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-3" style="font-size: 0.85rem;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- 名前 --}}
            <div class="mb-3">
                <label class="form-label">名前</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
            </div>

            {{-- メールアドレス --}}
            <div class="mb-3">
                <label class="form-label">メールアドレス</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            {{-- パスワード --}}
            <div class="mb-3">
                <label class="form-label">パスワード</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            {{-- パスワード確認 --}}
            <div class="mb-4">
                <label class="form-label">パスワード（確認）</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-register">登録する</button>
        </form>

        <div class="login-link">
            すでにアカウントをお持ちの方は
            <a href="{{ route('login') }}">ログイン</a>
        </div>
    </div>
</body>
</html>