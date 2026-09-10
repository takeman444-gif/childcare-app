<?php

namespace App\Http\Controllers;

use App\Models\BabyRecord;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // 管理者ダッシュボード
    public function index()
    {
        // 全記録数・論理削除済み件数を取得して表示
        $totalRecords   = BabyRecord::count();
        $trashedRecords = BabyRecord::onlyTrashed()->count();

        return view('admin.index', compact('totalRecords', 'trashedRecords'));
    }

    // 論理削除済み一覧表示
    public function trashed()
    {
        // onlyTrashed()で論理削除済みのレコードだけ取得
        $records = BabyRecord::onlyTrashed()
            ->with('child')
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('admin.trashed', compact('records'));
    }

    // 復元処理
    public function restore($id)
    {
        // withTrashed()で論理削除済みも含めて取得してから復元
        BabyRecord::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.trashed')->with('success', '記録を復元しました');
    }

    // 完全削除処理
    public function forceDelete($id)
    {
        // forceDelete()でDBから完全に削除
        BabyRecord::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.trashed')->with('success', '記録を完全に削除しました');
    }

    // CSVエクスポート
    public function export()
    {
        // 全記録をchild情報と一緒に取得
        $records = BabyRecord::with('child')->orderBy('recorded_at', 'desc')->get();

        // CSVのヘッダー行
        $csvHeader = ['ID', '子供の名前', '種別', 'メモ', '記録日時', '登録日時'];

        // レスポンスをCSVとして返す
        $response = response()->streamDownload(function () use ($records, $csvHeader) {
            $handle = fopen('php://output', 'w');

            // 文字化け防止のためBOMを追加
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // ヘッダー行を書き込む
            fputcsv($handle, $csvHeader);

            // データ行を書き込む
            foreach ($records as $record) {
                fputcsv($handle, [
                    $record->id,
                    $record->child ? $record->child->name : '未設定',
                    $record->category,
                    $record->memo,
                    $record->recorded_at,
                    $record->created_at,
                ]);
            }

            fclose($handle);
        }, 'baby_records.csv');

        

        return $response;
    }
        // ユーザー一覧表示
    public function users()
    {
        // 全ユーザーを取得
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    // 新規管理者ユーザー登録処理
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:50',
            'email'    => 'required|email|unique:users,email', // メールアドレスは重複不可
            'password' => 'required|min:8',                    // パスワードは8文字以上
            'is_admin' => 'boolean',                           // 管理者フラグ
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),          // パスワードをハッシュ化
            'is_admin' => $request->boolean('is_admin'),
        ]);

        return redirect()->route('admin.users')->with('success', 'ユーザーを追加しました');
    }

    // 管理者権限の付与・剥奪
    public function toggleAdmin(User $user)
    {
        // 自分自身の権限は変更できないようにする
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', '自分自身の権限は変更できません');
        }

        // is_adminを反転させる（true→false、false→true）
        $user->update(['is_admin' => !$user->is_admin]);
        return redirect()->route('admin.users')->with('success', '権限を変更しました');
    }
}