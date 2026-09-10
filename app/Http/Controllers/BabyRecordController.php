<?php

namespace App\Http\Controllers;

use App\Models\BabyRecord;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BabyRecordController extends Controller
{
    // 一覧表示
    public function index()
    {
        $records = BabyRecord::with('child')
            // ↓ ログイン中ユーザーの子供IDだけに絞る
            ->whereHas('child', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('recorded_at', 'desc')
            ->get();

        return view('baby_records.index', compact('records'));
    }

    // カレンダー表示
    public function calendar(Request $request)
    {
        $month = $request->month ? Carbon::parse($request->month) : Carbon::now();

        // ↓ ログイン中ユーザーの子供IDだけに絞る
        $childIds = Child::where('user_id', Auth::id())->pluck('id');

        $records = BabyRecord::whereIn('child_id', $childIds)
            ->whereYear('recorded_at', $month->year)
            ->whereMonth('recorded_at', $month->month)
            ->get()
            ->groupBy(function ($record) {
                return Carbon::parse($record->recorded_at)->format('Y-m-d');
            });

        return view('baby_records.calendar', compact('records', 'month'));
    }

    // 日別一覧表示
    public function daily(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date) : Carbon::now();

        // ↓ ログイン中ユーザーの子供IDだけに絞る
        $childIds = Child::where('user_id', Auth::id())->pluck('id');

        $records = BabyRecord::with('child')
            ->whereIn('child_id', $childIds)
            ->whereDate('recorded_at', $date)
            ->get();

        return view('baby_records.daily', compact('records', 'date'));
    }

    // 登録フォーム表示
    public function create()
    {
        $children = Child::where('user_id', Auth::id())->get();
        return view('baby_records.create', compact('children'));
    }

    // 登録処理
    public function store(Request $request)
    {
        $request->validate([
            'child_id'    => 'nullable|exists:children,id',
            'category'    => 'required|string|max:50',
            'memo'        => 'nullable|string',
            'recorded_at' => 'required|date',
            'image'       => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        BabyRecord::create([
            'child_id'    => $request->child_id,
            'category'    => $request->category,
            'memo'        => $request->memo,
            'recorded_at' => $request->recorded_at,
            'image_path'  => $imagePath,
        ]);

        return redirect()->route('baby_records.index')->with('success', '記録を登録しました');
    }

    // 編集フォーム表示
    public function edit(BabyRecord $babyRecord)
    {
        $children = Child::where('user_id', Auth::id())->get();
        return view('baby_records.edit', compact('babyRecord', 'children'));
    }

    // 更新処理
    public function update(Request $request, BabyRecord $babyRecord)
    {
        $request->validate([
            'child_id'    => 'nullable|exists:children,id',
            'category'    => 'required|string|max:50',
            'memo'        => 'nullable|string',
            'recorded_at' => 'required|date',
            'image'       => 'nullable|image|max:2048',
        ]);

        $imagePath = $babyRecord->image_path;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $babyRecord->update([
            'child_id'    => $request->child_id,
            'category'    => $request->category,
            'memo'        => $request->memo,
            'recorded_at' => $request->recorded_at,
            'image_path'  => $imagePath,
        ]);

        return redirect()->route('baby_records.index')->with('success', '記録を更新しました');
    }

    // 削除処理
    public function destroy(BabyRecord $babyRecord)
    {
        $babyRecord->delete();
        return redirect()->route('baby_records.index')->with('success', '記録を削除しました');
    }
}