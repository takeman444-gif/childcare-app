<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>育児記録編集</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">育児記録編集</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-4 bg-white">
        <form action="{{ route('baby_records.update', $babyRecord) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- 子供が2人以上いる場合のみ選択欄を表示 --}}
            @if($children->count() > 1)
                <div class="mb-3">
                    <label class="form-label">お子さんを選択</label>
                    <select name="child_id" class="form-select">
                        <option value="">選択してください</option>
                        @foreach($children as $child)
                            <option value="{{ $child->id }}"
                                @if($babyRecord->child_id === $child->id) selected @endif>
                                {{ $child->default_icon }} {{ $child->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @elseif($children->count() === 1)
                {{-- 子供が1人の場合は自動でセット（非表示） --}}
                <input type="hidden" name="child_id" value="{{ $children->first()->id }}">
            @endif
            <div class="mb-3">
                <label class="form-label">種別</label>
                <select name="category" class="form-select">
                    <option value="授乳" {{ $babyRecord->category == '授乳' ? 'selected' : '' }}>授乳</option>
                    <option value="睡眠" {{ $babyRecord->category == '睡眠' ? 'selected' : '' }}>睡眠</option>
                    <option value="排泄" {{ $babyRecord->category == '排泄' ? 'selected' : '' }}>排泄</option>
                    <option value="その他" {{ $babyRecord->category == 'その他' ? 'selected' : '' }}>その他</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">メモ</label>
                <textarea name="memo" class="form-control" rows="3">{{ $babyRecord->memo }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">記録日時</label>
                <input type="datetime-local" name="recorded_at" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($babyRecord->recorded_at)) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">写真</label>
                @if($babyRecord->image_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $babyRecord->image_path) }}" width="200">
                        <p class="text-muted" style="font-size: 0.85rem;">現在の画像</p>
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <p class="text-muted" style="font-size: 0.85rem;">変更する場合のみ選択してください</p>
            </div>

            <button type="submit" class="btn btn-warning">更新する</button>
            <a href="{{ route('baby_records.index') }}" class="btn btn-secondary">一覧に戻る</a>
        </form>
    </div>
</div>
</body>
</html>