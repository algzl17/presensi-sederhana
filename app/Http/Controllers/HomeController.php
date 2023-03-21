<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $jabatan = Jabatan::count();
        $karyawan = Karyawan::count();
        return view('home', compact('jabatan', 'karyawan'));
    }
}
