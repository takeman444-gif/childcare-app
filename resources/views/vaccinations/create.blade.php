<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予防接種記録登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">予防接種記録登録</h1>

    {{-- バリデーションエラー表示 --}}
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
        <form action="{{ route('vaccinations.store') }}" method="POST">
            @csrf

            {{-- お子さん選択 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">お子さん <span class="text-danger">*</span></label>
                <select name="child_id" class="form-select" required>
                    <option value="">選択してください</option>
                    @foreach($children as $child)
                        <option value="{{ $child->id }}" {{ old('child_id') == $child->id ? 'selected' : '' }}>
                            {{ $child->default_icon }} {{ $child->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ワクチン名（プルダウン） --}}
            <div class="mb-3">
                <label class="form-label fw-bold">ワクチン名 <span class="text-danger">*</span></label>
                <select name="vaccine_name" class="form-select" required>
                    <option value="">選択してください</option>
                    {{-- 定期接種 --}}
                    <optgroup label="定期接種">
                        <option value="ヒブワクチン" {{ old('vaccine_name') == 'ヒブワクチン' ? 'selected' : '' }}>ヒブワクチン</option>
                        <option value="小児用肺炎球菌" {{ old('vaccine_name') == '小児用肺炎球菌' ? 'selected' : '' }}>小児用肺炎球菌</option>
                        <option value="B型肝炎" {{ old('vaccine_name') == 'B型肝炎' ? 'selected' : '' }}>B型肝炎</option>
                        <option value="ロタウイルス" {{ old('vaccine_name') == 'ロタウイルス' ? 'selected' : '' }}>ロタウイルス</option>
                        <option value="四種混合（DPT-IPV）" {{ old('vaccine_name') == '四種混合（DPT-IPV）' ? 'selected' : '' }}>四種混合（DPT-IPV）</option>
                        <option value="BCG" {{ old('vaccine_name') == 'BCG' ? 'selected' : '' }}>BCG</option>
                        <option value="麻しん風しん混合（MR）" {{ old('vaccine_name') == '麻しん風しん混合（MR）' ? 'selected' : '' }}>麻しん風しん混合（MR）</option>
                        <option value="水痘（水ぼうそう）" {{ old('vaccine_name') == '水痘（水ぼうそう）' ? 'selected' : '' }}>水痘（水ぼうそう）</option>
                        <option value="日本脳炎" {{ old('vaccine_name') == '日本脳炎' ? 'selected' : '' }}>日本脳炎</option>
                        <option value="二種混合（DT）" {{ old('vaccine_name') == '二種混合（DT）' ? 'selected' : '' }}>二種混合（DT）</option>
                        <option value="HPV（子宮頸がん）" {{ old('vaccine_name') == 'HPV（子宮頸がん）' ? 'selected' : '' }}>HPV（子宮頸がん）</option>
                    </optgroup>
                    {{-- 任意接種 --}}
                    <optgroup label="任意接種">
                        <option value="おたふくかぜ" {{ old('vaccine_name') == 'おたふくかぜ' ? 'selected' : '' }}>おたふくかぜ</option>
                        <option value="インフルエンザ" {{ old('vaccine_name') == 'インフルエンザ' ? 'selected' : '' }}>インフルエンザ</option>
                        <option value="A型肝炎" {{ old('vaccine_name') == 'A型肝炎' ? 'selected' : '' }}>A型肝炎</option>
                    </optgroup>
                    {{-- その他 --}}
                    <optgroup label="その他">
                        <option value="その他" {{ old('vaccine_name') == 'その他' ? 'selected' : '' }}>その他</option>
                    </optgroup>
                </select>
            </div>

            {{-- 回数 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">回数 <span class="text-danger">*</span></label>
                <select name="dose_number" class="form-select" required>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('dose_number') == $i ? 'selected' : '' }}>{{ $i }}回目</option>
                    @endfor
                </select>
            </div>

            {{-- 接種日 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">接種日 <span class="text-danger">*</span></label>
                <input type="date" name="vaccinated_at" class="form-control" value="{{ old('vaccinated_at') }}" required>
            </div>

            {{-- 次回予定日 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">次回予定日</label>
                <input type="date" name="next_due_at" class="form-control" value="{{ old('next_due_at') }}">
            </div>

            {{-- 接種医療機関 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">接種医療機関</label>
                <input type="text" name="clinic_name" class="form-control" value="{{ old('clinic_name') }}" placeholder="例：〇〇クリニック">
            </div>

            {{-- 備考 --}}
            <div class="mb-3">
                <label class="form-label fw-bold">備考</label>
                <textarea name="memo" class="form-control" rows="3">{{ old('memo') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">登録する</button>
            <a href="{{ route('vaccinations.index') }}" class="btn btn-secondary">一覧に戻る</a>
        </form>
    </div>
</div>
</body>
</html>