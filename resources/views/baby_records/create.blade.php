<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>育児記録登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">育児記録登録</h1>

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
        <form action="{{ route('baby_records.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 子供が2人以上いる場合のみ選択欄を表示 --}}
            @if($children->count() > 1)
                <div class="mb-3">
                    <label class="form-label">お子さんを選択</label>
                    <select name="child_id" class="form-select">
                        <option value="">選択してください</option>
                        @foreach($children as $child)
                            <option value="{{ $child->id }}">
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
                    <option value="授乳">授乳</option>
                    <option value="睡眠">睡眠</option>
                    <option value="排泄">排泄</option>
                    <option value="その他">その他</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">メモ</label>
                <textarea name="memo" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">日時</label>
                <input type="datetime-local" name="recorded_at" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">写真</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">登録する</button>
            <a href="{{ route('baby_records.index') }}" class="btn btn-secondary">一覧に戻る</a>
        </form>
    </div>
</div>
<script>
    // ページを開いたとき、記録日時に現在日時を自動入力する
    window.addEventListener('load', function () {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        const formatted = `${year}-${month}-${day}T${hours}:${minutes}`;
        document.querySelector('input[name="recorded_at"]').value = formatted;
    });
</script>
</body>
</html>