<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>子供の情報登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">子供の情報登録</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-4 bg-white" style="border-radius: 15px; border: 1px solid #c8e6c9;">
        <form action="{{ route('children.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 名前 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">名前 <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            {{-- 性別 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">性別 <span class="text-danger">*</span></label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input type="radio" name="gender" value="boy" class="form-check-input"
                            @if(old('gender') === 'boy') checked @endif>
                        <label class="form-check-label">👦 男の子</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="gender" value="girl" class="form-check-input"
                            @if(old('gender') === 'girl') checked @endif>
                        <label class="form-check-label">👧 女の子</label>
                    </div>
                </div>
            </div>

            {{-- 生年月日 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">生年月日</label>
                <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}">
            </div>

            {{-- 出産予定日 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">出産予定日</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                <p class="text-muted" style="font-size: 0.85rem;">まだ生まれていない場合に入力してください</p>
            </div>

            {{-- プロフィール画像 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">プロフィール画像</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <p class="text-muted" style="font-size: 0.85rem;">画像がない場合は性別に応じたアイコンが表示されます</p>
            </div>

            <button type="submit" class="btn btn-primary">登録する</button>
            <a href="{{ route('children.index') }}" class="btn btn-secondary">マイページに戻る</a>
        </form>
    </div>
</div>
</body>
</html>
