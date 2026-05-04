<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Alert;
use App\Models\LogActivity;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }else{
            return view('login');
        }
    }

    public function authenticate(Request $request)
    {
        if($request->username != '' && $request->password != ''){
            $data = [
                'username' => $request->input('username'),
                'password' => $request->input('password'),
            ];
    
            if (Auth::Attempt($data)){

                // 🔥 Simpan LOG LOGIN
                LogActivity::create([
                    'user_id' => Auth::id(),
                    'activity' => 'LOGIN',
                    'created_at' => now()
                ]);

                return redirect()->route('home');
            }else{
                Alert::warning('Warning!', 'Username & Password salah!')->autoClose(1500);
                return back();
            }
        }else{
            Alert::warning('Warning!', 'Username & Password tidak boleh kosong!')->autoClose(1500);
            return back();
        }
    }

    public function logout()
    {
        // 🔥 Simpan LOG LOGOUT
        LogActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'LOGOUT',
            'created_at' => now()
        ]);

        Auth::logout();
        return redirect('/');
    }
}
