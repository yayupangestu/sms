<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            $menu = $request->segment(1);
            $lastMenu = session('last_accessed_menu');

            // Daftar menu yang log-nya HARUS masuk setiap refresh
            $forceLogMenus = [
                'scaninpswelding',
                'listrekapdadmp4',
                'listrekapd26adm',
                'listrekapd26',
                'scanoutls',
                'scaninpsdirect'
            ];

            if ($menu && !in_array($menu, ['login', 'logout'])) {

                // 👉 Jika menu termasuk force log → catat SETIAP refresh
                if (in_array($menu, $forceLogMenus)) {

                    LogActivity::create([
                        'user_id' => Auth::id(),
                        'activity' => 'ACCESS MENU: ' . $menu,
                        'created_at' => now(),
                    ]);

                    // Simpan menu ke session (optional)
                    session(['last_accessed_menu' => $menu]);

                } else {

                    // 👉 Untuk menu selain forceLogMenus
                    // Hanya catat jika ganti menu (bukan refresh)
                    if ($lastMenu !== $menu) {

                        LogActivity::create([
                            'user_id' => Auth::id(),
                            'activity' => 'ACCESS MENU: ' . $menu,
                            'created_at' => now(),
                        ]);

                        session(['last_accessed_menu' => $menu]);
                    }
                }
            }
        }

        return $next($request);
    }


}
