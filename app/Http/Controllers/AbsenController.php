<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsenController extends Controller
{

    public function scan(){
        return view('scan');
    }
    public function index()
    {
        $jurusan = Jurusan::all();
        $absensis = Absen::with('siswa')->orderBy('tanggal', 'desc')->get();

        return view('admin.absen.index', compact('absensis', 'jurusan'));
    }

    public function store(Request $request)
    {
        $nis = $request->id_siswa;

        $siswa = Siswa::where('nis', $nis)->first();

        if ($siswa) {
            $idSiswa = $siswa->id;

            $siswa = DB::table('siswas')
                ->where('nis', $nis)
                ->first();

            $cek = Absen::where([
                'id_siswa' => $idSiswa,
                // 'tanggal' => now(),
                'masuk' => date('Y-m-d'),

            ])->first();

            if ($cek) {
                return redirect('/scan')->with('gagal', 'Anda Sudah Absen');
            }

            $tanggalAbsen = now();
            // Set locale ke bahasa Indonesia
            Carbon::setLocale('id');
            $hariAbsen = Carbon::parse($tanggalAbsen)->isoFormat('dddd'); // Mendapatkan nama hari dalam bahasa Indonesia
            $jamAbsen = Carbon::now()->format('H:i:s');
            // dd($jamAbsen);// Debugging: Cek nilai waktu

            // Pengecekan waktu absensi
            if ($jamAbsen > '07:00:00') {
                $status = 'Terlambat';
            } else {
                $status = 'Tepat Waktu';
            }
            //  dd($status); // Debugging: Cek nilai status

            Absen::create([
                'id_siswa' => $idSiswa,
                'tanggal' => now(),
                'hari' => $hariAbsen,
                'status' => $status,
                'masuk' => date('Y-m-d'),
            ]);

            return redirect('/scan')->with('success', 'Silahkan masuk');
        } else {
            $tidakAda = "Tidak Terdaftar";
            return redirect('/scan')->with('tidakAda', $tidakAda);
        }
    }

    public function dailyReport(Request $request)
    {
        $jurusan = Jurusan::all();
        $tanggal = $request->input('masuk');
        $jurusanId = $request->input('jurusan');


        $query = Absen::whereHas('siswa', function ($q) use ($jurusanId) {
            $q->where('id_jurusan', $jurusanId);
        });
        if ($tanggal) {

            $query->where('masuk', Carbon::parse($tanggal)->format('Y-m-d'));
        }

        $data = $query->get();

        // dd($tanggal); // Tambahkan ini untuk debugging

        return view('admin.absen.dailyReport', compact('data', 'jurusan'));
    }

    public function printPdfDailyReport(Request $request)
    {
        $jurusan = Jurusan::all();
        $tanggal = $request->input('masuk');
        $jurusanId = $request->input('jurusan');


        $query = Absen::whereHas('siswa', function ($q) use ($jurusanId) {
            $q->where('id_jurusan', $jurusanId);
        });
        if ($tanggal) {

            $query->where('masuk', Carbon::parse($tanggal)->format('Y-m-d'));
        }

        $data = $query->get();

        // Generate PDF
        $pdf = PDF::loadView('admin.absen.daily', compact('data', 'jurusan'));

        // Download PDF
        return $pdf->download('harian_report.pdf');
    }

    public function monthlyReport(Request $request)
    {
        $jurusan = Jurusan::all();
        $bulan = $request->input('bulan');
        $jurusanId = $request->input('jurusan');

        $query = Absen::with('siswa');

        if ($bulan) {
            $query->whereMonth('tanggal', Carbon::parse($bulan)->month);
            $query->whereYear('tanggal', Carbon::parse($bulan)->year);
        }

        if ($jurusanId) {
            $query->whereHas('siswa', function ($q) use ($jurusanId) {
                $q->where('id_jurusan', $jurusanId);
            });
        }

        $monthlyReport = $query->get();

        return view('admin.absen.monthlyReport', compact('monthlyReport', 'jurusan'));
    }

    public function printPdfMonthlyReport(Request $request)
    {
        $jurusan = Jurusan::all();
        $bulan = $request->input('bulan');
        $jurusanId = $request->input('jurusan');

        $query = Absen::with('siswa');

        if ($bulan) {
            $query->whereMonth('tanggal', Carbon::parse($bulan)->month);
            $query->whereYear('tanggal', Carbon::parse($bulan)->year);
        }

        if ($jurusanId) {
            $query->whereHas('siswa', function ($q) use ($jurusanId) {
                $q->where('id_jurusan', $jurusanId);
            });
        }

        $data = $query->get();

        // Generate PDF
        $pdf = PDF::loadView('admin.absen.monthly', compact('data', 'jurusan'));

        // Download PDF
        return $pdf->download('bulanan_report.pdf');
    }

    public function periodReport(Request $request)
    {
        $jurusan = Jurusan::all();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $jurusanId = $request->input('jurusan');

        $query = Absen::with('siswa');

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        if ($jurusanId) {
            $query->whereHas('siswa', function ($q) use ($jurusanId) {
                $q->where('id_jurusan', $jurusanId);
            });
        }

        $periodReport = $query->get();

        return view('admin.absen.periodReport', compact('periodReport', 'jurusan'));
    }
    public function printPdfPeriodReport(Request $request)
    {
        $jurusan = Jurusan::all();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $jurusanId = $request->input('jurusan');

        $query = Absen::with('siswa');

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        if ($jurusanId) {
            $query->whereHas('siswa', function ($q) use ($jurusanId) {
                $q->where('id_jurusan', $jurusanId);
            });
        }

        $data = $query->get();

        // Generate PDF
        $pdf = PDF::loadView('admin.absen.periode', compact('data', 'jurusan'));

        // Download PDF
        return $pdf->download('periode_report.pdf');
    }
}
