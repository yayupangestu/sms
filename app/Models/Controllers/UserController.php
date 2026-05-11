<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {   
        $title = 'User';
        return view('user.index', compact('title'));
    }

    public function list(){
        $query = User::all();
        return Datatables::of($query)->make();
    }

    public function store(Request $request){
        $cek = User::where('username', $request->username)->count();
        if($cek > 0){
            return response()->json([
                'success'   => false,
                'msg'       => 'Insert failed. data already exist!'
            ]);
        }else{
            $user            = new User;
            $user->name      = $request->nama;
            $user->username  = $request->username;
            $user->password  = bcrypt($request->password);
            $user->level     = $request->level;
            $query = $user->save();
            if($query){
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Insert success.'
                ]);
            }else{
                return response()->json([
                    'success'   => false,
                    'msg'       => 'Insert failed.'
                ]);
            }
        }
    }

    public function edit(Request $request)
    {
        $qry = User::where('id', $request->id)->first();
        if($qry){
            return response()->json([
                'success'   => true,
                'id'        => $qry->id,
                'name'      => $qry->name,
                'username'  => $qry->username,
                'level'     => $qry->level
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Data not found.'
            ]);
        }
    }

    public function update(Request $request)
    {
        if($request->password == ''){
            $data['name']      = $request->nama;
            $data['username']  = $request->username;
            $data['level']     = $request->level;
            $query = User::where('id', $request->id)->update($data);
            if($query){
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Update data success.'
                ]);
            }else{
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Update data failed.'
                ]);
            }
        }else{
            $data['name']      = $request->nama;
            $data['username']  = $request->username;
            $data['password']  = bcrypt($request->password);
            $data['level']     = $request->level;
            $query = User::where('id', $request->id)->update($data);
            if($query){
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Update data success.'
                ]);
            }else{
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Update data failed.'
                ]);
            } 
        }
    }

    public function destroy(Request $request)
    {
        if($request->id == 1){
            return response()->json([
                'success'   => false,
                'msg'       => 'Delete data failed.'
            ]);
        }else{
            $query = User::where('id', $request->id)->delete();
            if($query){
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Delete data success.'
                ]);
            }else{
                return response()->json([
                    'success'   => false,
                    'msg'       => 'Delete data failed.'
                ]);
            }
        }
    }

    public function updatepwd(Request $request)
    {
        $id = auth()->user()->id;
        $data['password']  = bcrypt($request->pwd_baru);
        $query = User::where('id', $id)->update($data);
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Update data success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Update data failed.'
            ]);
        } 
    }
}
