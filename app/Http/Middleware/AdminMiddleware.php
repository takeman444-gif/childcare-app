<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * リクエストを処理する
     * 管理者以外はトップページにリダイレクト
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ログインしていない、またはis_adminが0の場合はリダイレクト
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('baby_records.index');
        }

        // 管理者の場合はそのまま通す
        return $next($request);
    }
}