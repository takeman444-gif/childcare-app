<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* プロフィール画像を丸く表示 */
        .child-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #c8e6c9;
        }

        /* 画像がない場合の絵文字アイコン */
        .child-emoji {
            font-size: 3rem;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f1f8e9;
            border-radius: 50%;
            border: 3px solid #c8e6c9;
        }

        .child-card {
            border-radius: 15px;
            border: 1px solid #c8e6c9;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">マイページ</h1>

    {{-- ログイン中のユーザー名を表示 --}}
    <p class="text-muted">ログイン中：{{ Auth::user()->name }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('children.create') }}" class="btn btn-primary mb-4">子供を追加する</a>

    @if($children->isEmpty())
        <div class="alert alert-info">まだ子供の情報が登録されていません。</div>
    @else
        <div class="row">
            @foreach($children as $child)
                <div class="col-md-4 mb-4">
                    <div class="card child-card p-3 text-center">

                        {{-- プロフィール画像 or 絵文字アイコン --}}
                        <div class="d-flex justify-content-center mb-3">
                            @if($child->image_path)
                                <img src="{{ asset('storage/' . $child->image_path) }}" class="child-icon">
                            @else
                                <div class="child-emoji">{{ $child->default_icon }}</div>
                            @endif
                        </div>

                        {{-- 子供の情報 --}}
                        <h5>{{ $child->name }}</h5>
                        <p class="text-muted" style="font-size: 0.85rem;">
                            {{ $child->gender === 'boy' ? '男の子' : '女の子' }}
                        </p>
                        @if($child->birthday)
                            <p style="font-size: 0.85rem;">🎂 {{ $child->birthday }}</p>
                        @endif
                        @if($child->due_date)
                            <p style="font-size: 0.85rem;">🏥 出産予定日：{{ $child->due_date }}</p>
                        @endif

                        {{-- 編集・削除ボタン --}}
                        <div class="mt-2">
                            <a href="{{ route('children.edit', $child) }}" class="btn btn-sm btn-warning">編集</a>
                            <form action="{{ route('children.destroy', $child) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('削除しますか？')">削除</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-3">
    <a href="{{ route('baby_records.index') }}" class="btn btn-secondary">育児記録一覧に戻る</a>
    </div>

    <div class="mt-2">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">ログアウト</button>
        </form>
    </div>

    
    </body>
    </html>