<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Baby;
use App\Models\Riwayat;
use Illuminate\Support\Arr;

class RiwayatController extends Controller
{
    public function index() {
        $id = Auth::user()->id;
        $baby = Baby::where('user_id', $id)->first();

        $riwayats = Riwayat::where('baby_id', $baby->id)->with('imunisasi')->get();

        return Inertia::render('Riwayat', [
            'baby' => $baby,
            'riwayats' => $riwayats,
        ]);
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'tgl_diberikan' => ['required'],
            'status' => ['required'],
        ])->validate();
    
        if ($request->has('id')) {
            Riwayat::find($request->input('id'))->update($request->all());
            //update baby atribut done
        }

        $id = Auth::user()->id;
        $baby = Baby::where('user_id', $id)->first();

        $done = Riwayat::where('baby_id', $baby->id)
            ->where('status', 'Sudah')
            ->get(['imunisasi_id'])->toArray();
        $done = Arr::flatten($done);
        $done = json_encode($done);

        $last_polio = Riwayat::where('baby_id',$baby->id)
            ->whereIn('imunisasi_id',[3,5,7,9])
            ->where('status','Sudah')
            ->orderBy('imunisasi_id','DESC')->first();
            if (!empty($last_polio)) {
                $last_polio = $last_polio->tgl_diberikan;
            }

        $last_dpt = Riwayat::where('baby_id',$baby->id)
            ->whereIn('imunisasi_id',[4,6,8,11])
            ->where('status','Sudah')
            ->orderBy('imunisasi_id','DESC')->first();
            if (!empty($last_dpt)) {
                $last_dpt = $last_dpt->tgl_diberikan;
            }

        $last_mr = Riwayat::where('baby_id',$baby->id)
            ->whereIn('imunisasi_id',[10,12])
            ->where('status','Sudah')
            ->orderBy('imunisasi_id','DESC')->first();
                if (!empty($last_mr)) {
                    $last_mr = $last_mr->tgl_diberikan;
                }
                
        app('App\Http\Controllers\BabyController')->rules($baby->id, $baby->ttl, $baby->bb, $done, $last_polio, $last_dpt, $last_mr);

        return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
    }
}
