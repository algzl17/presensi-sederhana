<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Karyawan::with('jabatan');
            if (request()->ajax() && !request()->get('order')) {
                $query = $query->orderByDesc('created_at');
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return date('d/m/Y', strtotime($row->created_at));
                })
                ->addColumn('qrcode', function ($row) {
                    return QrCode::size(25)->generate($row->nik);
                })
                ->addColumn('aksi', function ($row) {
                    return '<div class="flex justify-center">
                    <button data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Sunting Data" onclick="editItem(' . $row->id_karyawan . ')" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit"></i>
                    </button>
                    <button data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Hapus Data" onclick="deleteItem(' . $row->id_karyawan . ')" class="btn btn-danger btn-sm">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>';
                })->rawColumns(['aksi', 'qrcode'])
                ->make(true);
        }
        $jabatan = Jabatan::query()->orderBy('jabatan')->get();
        return view('karyawan', compact('jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Karyawan::create($request->post());
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Karyawan::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return Karyawan::find($id)->update($request->post());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Karyawan::destroy($id);
    }
}
