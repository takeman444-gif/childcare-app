<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>子供の情報編集</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">子供の情報編集</h1>

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
        <form action="{{ route('children.update', $child) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- 名前 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">名前 <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $child->name) }}" required>
            </div>

            {{-- 性別 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">性別 <span class="text-danger">*</span></label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input type="radio" name="gender" value="boy" class="form-check-input"
                            @if(old('gender', $child->gender) === 'boy') checked @endif>
                        <label class="form-check-label">👦 男の子</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="gender" value="girl" class="form-check-input"
                            @if(old('gender', $child->gender) === 'girl') checked @endif>
                        <label class="form-check-label">👧 女の子</label>
                    </div>
                </div>
            </div>

            {{-- 生年月日 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">生年月日</label>
                <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $child->birthday) }}">
            </div>

            {{-- 出産予定日 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">出産予定日</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $child->due_date) }}">
            </div>

            {{-- プロフィール画像 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">プロフィール画像</label>

                {{-- 現在の画像 or デフォルトアイコンを表示 --}}
                <div class="mb-2">
                    @if($child->image_path)
                        <img src="{{ asset('storage/' . $child->image_path) }}"
                             width="80" height="80"
                             style="border-radius: 50%; object-fit: cover; border: 3px solid #c8e6c9;">
                    @else
                        <div style="font-size: 3rem;">{{ $child->default_icon }}</div>
                    @endif
                    <p class="text-muted" style="font-size: 0.85rem;">現在の画像</p>
                </div>

                <input type="file" name="image" class="form-control" accept="image/*">
                <p class="text-muted" style="font-size: 0.85rem;">変更する場合のみ選択してください</p>
            </div>

            <button type="submit" class="btn btn-warning">更新する</button>
            <a href="{{ route('children.index') }}" class="btn btn-secondary">マイページに戻る</a>
        </form>
    </div>
</div>
</body>
</html>