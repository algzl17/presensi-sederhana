<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JabatanController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Jabatan::query();
            if (request()->ajax() && !request()->get('order')) {
                $query = $query->orderByDesc('created_at');
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return date('d/m/Y', strtotime($row->created_at));
                })
                ->addColumn('aksi', function ($row) {
                    return '<div class="flex justify-center">
                    <button data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Sunting Data" onclick="editItem(' . $row->id_jabatan . ')" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit"></i>
                    </button>
                    <button data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Hapus Data" onclick="deleteItem(' . $row->id_jabatan . ')" class="btn btn-danger btn-sm">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>';
                })->rawColumns(['aksi'])
                ->make(true);
        }
        return view('jabatan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Jabatan::create($request->post());
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Jabatan::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return Jabatan::find($id)->update($request->post());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Jabatan::destroy($id);
    }
}
