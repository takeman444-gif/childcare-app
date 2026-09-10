<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaccinationController extends Controller
{
    // 予防接種記録一覧表示
    public function index()
    {
        // ログイン中のユーザーの子供に紐づく予防接種記録を取得
        $childIds = Child::where('user_id', Auth::id())->pluck('id');
        $vaccinations = Vaccination::with('child')
            ->whereIn('child_id', $childIds)
            ->orderBy('vaccinated_at', 'desc')
            ->get();

        return view('vaccinations.index', compact('vaccinations'));
    }

    // 登録フォーム表示
    public function create()
    {
        // ログイン中のユーザーの子供一覧を取得
        $children = Child::where('user_id', Auth::id())->get();
        return view('vaccinations.create', compact('children'));
    }

    // 登録処理
    public function store(Request $request)
    {
        $request->validate([
            'child_id'      => 'required|exists:children,id', // 子供は必須
            'vaccine_name'  => 'required|string|max:100',     // ワクチン名は必須
            'dose_number'   => 'required|integer|min:1',      // 回数は必須・1以上
            'vaccinated_at' => 'required|date',               // 接種日は必須
            'next_due_at'   => 'nullable|date',               // 次回予定日は任意
            'manufacturer'  => 'nullable|string|max:100',     // メーカー名は任意
            'lot_number'    => 'nullable|string|max:50',      // ロット番号は任意
            'clinic_name'   => 'nullable|string|max:100',     // 接種医療機関は任意
            'memo'          => 'nullable|string',             // 備考は任意
        ]);

        Vaccination::create($request->only([
            'child_id', 'vaccine_name', 'dose_number', 'vaccinated_at',
            'next_due_at', 'manufacturer', 'lot_number', 'clinic_name', 'memo',
        ]));

        return redirect()->route('vaccinations.index')->with('success', '予防接種記録を登録しました');
    }

    // 編集フォーム表示
    public function edit(Vaccination $vaccination)
    {
        // ログイン中のユーザーの子供一覧を取得
        $children = Child::where('user_id', Auth::id())->get();
        return view('vaccinations.edit', compact('vaccination', 'children'));
    }

    // 更新処理
    public function update(Request $request, Vaccination $vaccination)
    {
        $request->validate([
            'child_id'      => 'required|exists:children,id',
            'vaccine_name'  => 'required|string|max:100',
            'dose_number'   => 'required|integer|min:1',
            'vaccinated_at' => 'required|date',
            'next_due_at'   => 'nullable|date',
            'manufacturer'  => 'nullable|string|max:100',
            'lot_number'    => 'nullable|string|max:50',
            'clinic_name'   => 'nullable|string|max:100',
            'memo'          => 'nullable|string',
        ]);

        $vaccination->update($request->only([
            'child_id', 'vaccine_name', 'dose_number', 'vaccinated_at',
            'next_due_at', 'manufacturer', 'lot_number', 'clinic_name', 'memo',
        ]));

        return redirect()->route('vaccinations.index')->with('success', '予防接種記録を更新しました');
    }

    // 削除処理（論理削除）
    public function destroy(Vaccination $vaccination)
    {
        $vaccination->delete();
        return redirect()->route('vaccinations.index')->with('success', '予防接種記録を削除しました');
    }
}