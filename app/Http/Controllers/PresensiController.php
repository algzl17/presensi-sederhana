<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Presensi;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PresensiController extends Controller
{
    public function index()
    {
        if (!session()->has('absen')) {
            session()->put('absen', 'masuk');
        }
        if (request()->ajax()) {
            $query = Karyawan::query()
                ->leftJoin('mst_jabatan as b', 'b.id_jabatan', 'mst_karyawan.id_jabatan')
                ->leftJoin('presensi as a', function ($join) {
                    $join->on('a.id_karyawan', '=', 'mst_karyawan.id_karyawan');
                    $join->on('a.tanggal', '=', DB::raw("'" . date('Y-m-d') . "'"));
                })
                ->where('mst_karyawan.status', 1)
                ->select('a.*', 'mst_karyawan.id_karyawan as idk', 'mst_karyawan.nama', 'b.jabatan');

            if (request()->ajax() && !request()->get('order')) {
                $query = $query->orderByDesc('id');
            }

            return DataTables::of($query->get())
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    if ($row->status == 'H') {
                        return 'Hadir';
                    } elseif ($row->status == 'I') {
                        return 'Izin';
                    } elseif ($row->status == 'A') {
                        return 'Alfa';
                    }
                    return 'Belum';
                })
                ->editColumn('masuk', function ($row) {
                    if ($row->masuk) {
                        return date('H:i', strtotime($row->masuk)) . " WIB";
                    }
                    return '-';
                })
                ->editColumn('pulang', function ($row) {
                    if ($row->pulang) {
                        return date('H:i', strtotime($row->pulang)) . " WIB";
                    }
                    return '-';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                    <button data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Sunting" onclick="editpre(' . $row->idk . ')" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit"></i>
                    </button>
                    ';
                })->rawColumns(['aksi', 'status'])
                ->make(true);
        }
        return view('presensi');
    }

    public function absen($qr)
    {
        $karyawan = Karyawan::with('jabatan')->where('nik', $qr)->first();
        if ($karyawan) {
            $cek = DB::table('presensi')
                ->where('id_karyawan', $karyawan->id_karyawan)
                ->where('tanggal', date('Y-m-d'))
                ->whereNotNull(session('absen'))
                ->first();

            if (!$cek) {
                DB::table('presensi')
                    ->updateOrInsert([
                        'id_karyawan' => $karyawan->id_karyawan,
                        'tanggal' => date('Y-m-d')
                    ], [
                        'status' => 'H',
                        session('absen') => date('H:i:s')
                    ]);
                return response()->json([
                    'status' => true,
                    'result' => [
                        'nama' => $karyawan->nama,
                        'jabatan' => $karyawan->jabatan->jabatan,
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Sudah presensi!'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'error' => 'QRcode tidak terdaftar!'
            ]);
        }
    }

    public function edit($id)
    {
        return Karyawan::query()
            ->leftJoin('mst_jabatan as b', 'b.id_jabatan', 'mst_karyawan.id_jabatan')
            ->leftJoin('presensi as a', function ($join) {
                $join->on('a.id_karyawan', '=', 'mst_karyawan.id_karyawan');
                $join->on('a.tanggal', '=', DB::raw("'" . date('Y-m-d') . "'"));
            })
            ->where('mst_karyawan.id_karyawan', $id)
            ->select('a.*', 'mst_karyawan.id_karyawan as idk', 'mst_karyawan.nama', 'mst_karyawan.nik', 'b.jabatan')
            ->first();
    }

    public function update($id)
    {
        DB::table('presensi')
            ->updateOrInsert([
                'id_karyawan' => $id,
                'tanggal' => date('Y-m-d')
            ], [
                'status' => request()->get('status'),
                'masuk' => null,
                'pulang' => null,
            ]);
        return response()->json(['status', true]);
    }

    public function batal($id)
    {
        $tipe = request()->get('tipe') ?? session('absen');

        DB::table('presensi')
            ->where('id_karyawan', $id)
            ->where('tanggal', date('Y-m-d'))
            ->update([$tipe => null]);


        $hapus = DB::table('presensi')
            ->where('id_karyawan', $id)
            ->where('tanggal', date('Y-m-d'))
            ->whereNull('masuk')
            ->whereNull('pulang')
            ->first();

        if ($hapus) {
            DB::table('presensi')
                ->where('id_karyawan', $id)
                ->where('tanggal', date('Y-m-d'))
                ->delete();
        }

        return response()->json(['status', true]);
    }

    public function presensi_pilih($val)
    {
        session()->put('absen', $val);
        return response()->json(['status', true]);
    }
}
