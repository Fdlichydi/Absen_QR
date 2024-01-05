<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('admin.jurusan.index',compact('jurusan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Jurusan::create([
            'nama_jurusan'=> $request->nama_jurusan,
        ]);
        return redirect('/jurusan')->with('tambah','');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::find($id);
        $jurusan->update([
            'nama_jurusan'=> $request->nama_jurusan,
        ]);
        return redirect('/jurusan')->with('ubah','');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jurusan = Jurusan::find($id);
        $jurusan->delete();
        return redirect('/jurusan')->with('hapus','');
    }
}
