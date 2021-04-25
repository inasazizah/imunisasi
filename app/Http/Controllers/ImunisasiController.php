<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Imunisasi;

class ImunisasiController extends Controller
{
    public function detail($id) {
        //ambil data id dari url > detail/1
        // data di tabel imunisasi
        $imunisasi = Imunisasi::find($id);
        //return view DetailImunisasi
        return Inertia::render('DetailImunisasi', [
            'imunisasi' => $imunisasi,
        ]);
    }
    public function info(){
        $imunisasis = Imunisasi::all();
        return Inertia::render('InfoImunisasi', [
            'imunisasis' => $imunisasis,
        ]);
    }
}
