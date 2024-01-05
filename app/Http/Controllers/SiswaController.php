<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;


class SiswaController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        $jurusan1 = Jurusan::all();
        $siswa = Siswa::latest()->get();
        return view('admin.siswa.index', compact('siswa', 'jurusan', 'jurusan1'));
    }

    // public function store(Request $request)
    // {
    //     $filename = null;
    //     if($request->foto){
    //         $filename = $request->foto->getClientOriginalName();
    //         $request->file('foto')->move('assets/images/', $request->foto->getClientOriginalName());
    //     }
    //     $data = $request->validate([
    //         'nis' => 'required',
    //         'nama' => 'required',
    //         'id_jurusan' => 'required',
    //         'foto' => $filename,
    //     ]);

    //     // Menyimpan data siswa
    //     $siswa = Siswa::create($data);
    //     $id = $siswa->id;

    //     // Menghasilkan dan menyimpan QR Code
    //     $this->generateAndSaveQrCode($data['nis'], $id);

    //     return redirect('/siswa')->with('tambah', '');
    // }

    public function store(Request $request)
    {
        $filename = null;

        // Upload foto jika ada
        // if ($request->hasFile('foto')) {
        //     $filename = $request->foto->getClientOriginalName();
        //     $request->file('foto')->move('assets/images/', $filename);
        // }

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $nis = $request->nis; // Ambil nilai NIS
            $filename = $nis . '_' . time() . '.' . $request->foto->getClientOriginalExtension();
            $request->file('foto')->move('assets/images/', $filename);
        }

        $data = $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'id_jurusan' => 'required',
        ]);

        // Tambahkan filename ke dalam array data jika ada file foto
        if ($filename) {
            $data['foto'] = $filename;
        }

        // Menyimpan data siswa
        $siswa = Siswa::create($data);
        $id = $siswa->id;

        // Menghasilkan dan menyimpan QR Code
        $this->generateAndSaveQrCode($data['nis'], $id);

        return redirect('/siswa')->with('tambah', '');
    }


    public function generateAndSaveQrCode($nis, $id)
    {
        // Menghasilkan QR Code
        $qrCode = new QrCode($nis);
        // Menyimpan QR Code sebagai gambar di folder public/qrcodes/
        $qrCode->writeFile(public_path('qrcodes/' . $nis . '.png'));

        // Simpan nama file QR Code ke dalam tabel siswas
        DB::table('siswas')->where('id', $id)->update(['qrcode' => 'qrcodes/' . $nis . '.png']);
    }
    public function printQrPdf($id)
    {
        $siswa = Siswa::findOrFail($id);
        $qrCode = new QrCode($siswa->nis);
        if ($qrCode->getErrorCorrectionLevel() === null) {
            return redirect()->back()->with('error', 'Gagal menghasilkan QR Code.');
        }
        $pdf = PDF::loadView('admin.siswa.qr', compact('siswa', 'qrCode'));

        return $pdf->download('qr_code.pdf');
    }

    // public function update(Request $request, $id)
    // {
    //     $siswa = Siswa::find($id);

    //     // if (!$siswa) {
    //     //     return redirect('/siswa')->with('error', 'Data siswa tidak ditemukan');
    //     // }

    //     $siswa->update([
    //         'nis' => $request->nis,
    //         'nama' => $request->nama,
    //         'id_jurusan' => $request->id_jurusan,
    //     ]);
    //     $data = $request->validate([
    //         'nis' => 'required',
    //         'nama' => 'required',
    //         'id_jurusan' => 'required',
    //     ]);
    //     // Menghasilkan dan menyimpan QR Code
    //     $this->generateAndSaveQrCode($data['nis'], $id);

    //     return redirect('/siswa')->with('ubah', '');
    // }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        $filename = null;

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($siswa->foto != '') {
                unlink('assets/images/' . $siswa->foto);
            }

            $nis = $request->nis; // Ambil nilai NIS
            $filename = $nis . '_' . time() . '.' . $request->foto->getClientOriginalExtension();
            $request->file('foto')->move('assets/images/', $filename);
        }

        $data = $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'id_jurusan' => 'required',
        ]);
        // Menghasilkan dan menyimpan QR Code
        $this->generateAndSaveQrCode($data['nis'], $id);
        // Tambahkan filename ke dalam array data jika ada file foto
        if ($filename) {
            $data['foto'] = $filename;
        }

        // Update data siswa
        $siswa->update($data);

        return redirect('/siswa')->with('update', '');
    }

    public function update1(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return redirect('/siswa')->with('error', 'Data siswa tidak ditemukan');
        }

        // Perbarui data siswa dengan nilai yang sudah ada dalam objek $siswa
        $siswa->update([
            'nis' => $siswa->nis,
            'nama' => $siswa->nama,
            'id_jurusan' => $siswa->id_jurusan,
        ]);
        $data = $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'id_jurusan' => 'required',
        ]);
        // Menghasilkan dan menyimpan QR Code
        $this->generateAndSaveQrCode($data['nis'], $id);

        return redirect('/siswa')->with('ubah', '');
    }


    public function destroy($id)
    {
        $siswa = Siswa::find($id);

        // if (!$siswa) {
        //     return redirect('/siswa')->with('error', 'Data siswa tidak ditemukan');
        // }
        if ($siswa->foto != '') {
            unlink('assets/images/' . $siswa->foto);
        }

        $siswa->delete();
        return redirect('/siswa')->with('hapus', '');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $file = $request->file('file');

        Excel::import(new SiswaImport, $file);

        return redirect('/siswa')->with('success', 'Data siswa berhasil diimpor.');
    }
}
