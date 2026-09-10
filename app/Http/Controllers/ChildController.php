<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    // マイページ：子供一覧表示
    public function index()
    {
        // ログイン中のユーザーの子供だけ取得
        $children = Auth::user()->children;
        return view('children.index', compact('children'));
    }

    // 子供登録フォーム表示
    public function create()
    {
        return view('children.create');
    }

    // 子供登録処理
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:50',  // 名前は必須
            'gender'   => 'required|in:boy,girl',    // 性別は boy か girl のみ
            'birthday' => 'nullable|date',            // 生年月日は任意
            'due_date' => 'nullable|date',            // 出産予定日は任意
            'image'    => 'nullable|image|max:2048',  // 画像は任意・2MBまで
        ]);

        // 画像がアップロードされた場合は保存
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('children', 'public');
        }

        // ログイン中のユーザーIDと一緒に保存
        Child::create([
            'user_id'    => Auth::id(),
            'name'       => $request->name,
            'gender'     => $request->gender,
            'birthday'   => $request->birthday,
            'due_date'   => $request->due_date,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('children.index')->with('success', '子供の情報を登録しました');
    }

    // 子供編集フォーム表示
    public function edit(Child $child)
    {
        // 他のユーザーの子供は編集できないようにする
        abort_if($child->user_id !== Auth::id(), 403);
        return view('children.edit', compact('child'));
    }

    // 子供更新処理
    public function update(Request $request, Child $child)
    {
        // 他のユーザーの子供は更新できないようにする
        abort_if($child->user_id !== Auth::id(), 403);

        $request->validate([
            'name'     => 'required|string|max:50',
            'gender'   => 'required|in:boy,girl',
            'birthday' => 'nullable|date',
            'due_date' => 'nullable|date',
            'image'    => 'nullable|image|max:2048',
        ]);

        // 新しい画像があれば更新、なければ既存の画像を維持
        $imagePath = $child->image_path;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('children', 'public');
        }

        $child->update([
            'name'       => $request->name,
            'gender'     => $request->gender,
            'birthday'   => $request->birthday,
            'due_date'   => $request->due_date,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('children.index')->with('success', '子供の情報を更新しました');
    }

    // 子供削除処理
    public function destroy(Child $child)
    {
        // 他のユーザーの子供は削除できないようにする
        abort_if($child->user_id !== Auth::id(), 403);
        $child->delete();
        return redirect()->route('children.index')->with('success', '子供の情報を削除しました');
    }
}