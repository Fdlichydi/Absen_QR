<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('admin.user.index',compact('user'));
    }
    public function store(Request $request)
    {
        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password,
        ]);
        return redirect('/user')->with('tambah','');
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password,
        ]);
        return redirect('/user')->with('ubah','');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/user')->with('hapus','');
    }
}
