<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Baby;
use App\Models\Imunisasi;
use App\Models\Riwayat;
use DateTime;
use DateInterval;

class BabyController extends Controller
{
    public function create() {
        return Inertia::render('FormInput');
    }

    public function store(Request $request) {
        Validator::make($request->all(), [
            'nama' => ['required', 'max:50'],
            'ttl' => ['required', 'max:50'],
            'bb' => ['required', 'max:50'],
        ])->validate();

        $baby= Baby::create($request->only(['nama','ttl','bb','user_id'])); // ambil id baby

        // menyimpan data riwayat (belum + sudah)   

        // ambil semua data tabel imunisasis
        $imunisasis = Imunisasi::get();
        
        // iterasi data tabel imunisasis
        foreach ($imunisasis as $imunisasi) {
            Riwayat::create([
                'baby_id' => $baby->id,
                'imunisasi_id' => $imunisasi->id,
            ]);
        }

        BabyController::rules($baby->id, $baby->ttl, $baby->bb, $request->done, $request->last_polio, $request->last_dpt, $request->last_mr);

        // update status riwayat

        // simpan semua
  
        return redirect()->route('form.show');
    }

    public function show() {
        $id = Auth::user()->id;
        $baby = Baby::where('user_id', $id)->first();

        $riwayats = Riwayat::where('baby_id', $baby->id)->with('imunisasi')->get();

        return Inertia::render('FormOutput', [
            'baby' => $baby,
            'riwayats' => $riwayats,
        ]);
    }

    public function rules($baby_id, $ttl, $bb, $done, $last_polio, $last_dpt, $last_mr)
    {
        $im = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];

        //interval antar imunisasi
        $interval = new DateInterval('P1M');
        $interval2 = new DateInterval('P2M');
        $interval3 = new DateInterval('P3M');
        $interval4 = new DateInterval('P4M');
        $interval6 = new DateInterval('P6M');
        $interval9 = new DateInterval('P9M'); 
        $interval18 = new DateInterval('P18M');
        $interval24 = new DateInterval('P24M');

        //input dari user
        $ttl = new DateTime($ttl);
        $now = new DateTime();
        $usia = $now->diff($ttl)->m;
        $done = json_decode($done);
        $last_polio = new DateTime($last_polio);
        $last_dpt = new DateTime($last_dpt);
        $last_mr = new DateTime($last_mr);


        function check($all, $search_this) {
            return count(array_intersect($search_this, $all)) == count($search_this);
        }

        // update tanggal penjadwalan riwayat
        //berat badan tidak mencukupi
        if ($bb < 2) {
            echo "Tidak imunisasi karena berat badan tidak sampai 2 kg";
        }
        else {
            //HB0
            if ($usia == 0 && !in_array($im[0], $done)) {
                $tgl_imunisasi = clone $ttl;
                $tgl_imunisasi = $tgl_imunisasi->format('Y-m-d');
                // echo "Imunisasi $im[0] pada tanggal $tgl_imunisasi <br>";
                $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 1)->first();
                $riwayat->tgl_penjadwalan = $tgl_imunisasi;
                $riwayat->save();
            }
            //BCG
            if ($usia < 1 && !in_array($im[1], $done)) {
                $tgl_imunisasi = clone $ttl;
                $tgl_imunisasi->add($interval);
                $tgl_imunisasi = $tgl_imunisasi->format('Y-m-d');
                // echo "Imunisasi $im[1] pada tanggal $tgl_imunisasi <br>";
                $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 2)->first();
                $riwayat->tgl_penjadwalan = $tgl_imunisasi;
                $riwayat->save();
            
            } elseif ($usia >= 1 && $usia <= 3 && !in_array($im[1], $done)) {
                $tgl_imunisasi = clone $now;
                $tgl_imunisasi = $tgl_imunisasi->format('Y-m-d');
                // echo "Imunisasi $im[1] pada tanggal $tgl_imunisasi <br>";
                $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 2)->first();
                $riwayat->tgl_penjadwalan = $tgl_imunisasi;
                $riwayat->save();
            }
            //Polio 1
            if ($usia < 1 && !in_array($im[2], $done)) {
                $tgl_imunisasi = clone $ttl;
                $tgl_imunisasi = $tgl_imunisasi->add($interval)->format('Y-m-d');
                // echo "Imunisasi $im[2] pada tanggal $tgl_imunisasi <br>";
                $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 3)->first();
                $riwayat->tgl_penjadwalan = $tgl_imunisasi;
                $riwayat->save();
            } elseif ($usia >= 1 && $usia <= 24 && !in_array($im[2], $done)) {
                $tgl_imunisasi = clone $now;
                $tgl_imunisasi = $tgl_imunisasi->format('Y-m-d');
                // echo "Imunisasi $im[2] pada tanggal $tgl_imunisasi <br>";
                $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 3)->first();
                $riwayat->tgl_penjadwalan = $tgl_imunisasi;
                $riwayat->save();
            }
            //Polio 2
            if ($usia < 2 && in_array($im[2], $done) && !in_array($im[4], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_polio;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval2);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[4] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 5)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[4] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 5)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            } elseif ($usia >= 2 && $usia <= 24 && in_array($im[2], $done) && !in_array($im[4], $done)) {
                $tgl_imunisasi1 = clone $last_polio;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[4] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 5)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[4] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 5)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            }
            //Polio 3
            if ($usia < 3 && in_array($im[4], $done) && !in_array($im[6], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_polio;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval3);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[6] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 7)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[6] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 7)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            } elseif ($usia >= 3 && $usia <= 24 && in_array($im[4], $done) && !in_array($im[6], $done)) {
                $tgl_imunisasi1 = clone $last_polio;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[6] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 7)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[6] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 7)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            }
            //Polio 4
            if ($usia < 4 && in_array($im[6], $done) && !in_array($im[8], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_polio;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval4);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[8] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 9)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[8] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 9)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            } elseif ($usia >= 4 && $usia <= 24 && in_array($im[6], $done) && !in_array($im[8], $done)) {
                $tgl_imunisasi1 = clone $last_polio;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[8] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 9)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[8] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 9)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            }
            //DPT-HB-Hib 1
            if ($usia < 2 && !in_array($im[3], $done)) {
                $tgl_imunisasi = clone $ttl;
                $tgl_imunisasi = $tgl_imunisasi->add($interval2)->format('Y-m-d');
                // echo "Imunisasi $im[3] pada tanggal $tgl_imunisasi <br>";
                $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 4)->first();
                $riwayat->tgl_penjadwalan = $tgl_imunisasi;
                $riwayat->save();
            } elseif ($usia >= 2 && $usia <= 24 && !in_array($im[3], $done)) {
                $tgl_imunisasi = clone $now;
                $tgl_imunisasi = $tgl_imunisasi->format('Y-m-d');
                // echo "Imunisasi $im[3] pada tanggal $tgl_imunisasi <br>";
                $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 4)->first();
                $riwayat->tgl_penjadwalan = $tgl_imunisasi;
                $riwayat->save();
            }
            //DPT-HB-Hib 2
            if ($usia < 3 && in_array($im[3], $done) && !in_array($im[5], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_dpt;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval3);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[5] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 6)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[5] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 6)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            } elseif ($usia >= 3 && $usia <= 24 && in_array($im[3], $done) && !in_array($im[5], $done)) {
                $tgl_imunisasi1 = clone $last_dpt;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[5] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 6)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[5] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 6)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            }
            //DPT-HB-Hib 3
            if ($usia < 4 && in_array($im[5], $done) && !in_array($im[7], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_dpt;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval4);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[7] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 8)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[7] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 8)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            } elseif ($usia >= 4 && $usia <= 24 && in_array($im[5], $done) && !in_array($im[7], $done)) {
                $tgl_imunisasi1 = clone $last_dpt;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[7] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 8)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[7] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 8)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            }
            //DPT-HB-Hib Lanjutan
            if ($usia < 18 && in_array($im[7], $done) && !in_array($im[10], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_dpt;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval18);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[10] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 11)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[10] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 11)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            } elseif ($usia >= 18 && $usia <= 24 && in_array($im[7], $done) && !in_array($im[10], $done)) {
                $tgl_imunisasi1 = clone $last_dpt;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[10] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 11)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[10] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 11)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            }
            //MR
            if ($usia < 9 &&  !in_array($im[9], $done)) {
                $tgl_imunisasi = clone $ttl;
                $tgl_imunisasi = $tgl_imunisasi->add($interval9)->format('Y-m-d');
                // echo "Imunisasi $im[9] pada tanggal $tgl_imunisasi <br>";
                $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 10)->first();
                $riwayat->tgl_penjadwalan = $tgl_imunisasi;
                $riwayat->save();
            } elseif ($usia >= 9 && $usia <= 24 && !in_array($im[9], $done)) {
                $tgl_imunisasi = clone $now;
                $tgl_imunisasi = $tgl_imunisasi->format('Y-m-d');
                // echo "Imunisasi $im[9] pada tanggal $tgl_imunisasi <br>";
                $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 10)->first();
                $riwayat->tgl_penjadwalan = $tgl_imunisasi;
                $riwayat->save();
            }
            //MR Lanjutan
            if ($usia <= 24 && in_array($im[9], $done) && !in_array($im[11], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_mr;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval24);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval6);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('Y-m-d');
                    // echo "Imunisasi $im[11] pada tanggal $tgl_imunisasi1 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 12)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi1;
                    $riwayat->save();
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('Y-m-d');
                    // echo "Imunisasi $im[11] pada tanggal $tgl_imunisasi2 <br>";
                    $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 12)->first();
                    $riwayat->tgl_penjadwalan = $tgl_imunisasi2;
                    $riwayat->save();
                }
            }
        }

        // update status riwayat
        //HB0
        if (in_array($im[0], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 1)->first();
            $riwayat->status = 'Sudah';
            $riwayat->save();
        } 
        //BCG
        if (in_array($im[1], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 2)->first();
            $riwayat->status = 'Sudah';
            $riwayat->save();
        }
        //Polio 1
        if (in_array($im[2], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 3)->first();
            $riwayat->status = 'Sudah';
            if(!in_array($im[4], $done)){
                $riwayat->tgl_diberikan = $last_polio;
            }
            $riwayat->save();
        }
        //DPT 1
        if (in_array($im[3], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 4)->first();
            $riwayat->status = 'Sudah';
            if(!in_array($im[5], $done)){
                $riwayat->tgl_diberikan = $last_dpt;
            }
            $riwayat->save();
        }
        //Polio 2
        if (in_array($im[4], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 5)->first();
            $riwayat->status = 'Sudah';
            if(!in_array($im[6], $done)){
                $riwayat->tgl_diberikan = $last_polio;
            }
            $riwayat->save();
        }
        //DPT 2
        if (in_array($im[5], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 6)->first();
            $riwayat->status = 'Sudah';
            if(!in_array($im[7], $done)){
                $riwayat->tgl_diberikan = $last_dpt;
            }
            $riwayat->save();
        }
        //Polio 3
        if (in_array($im[6], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 7)->first();
            $riwayat->status = 'Sudah';
            if(!in_array($im[8], $done)){
                $riwayat->tgl_diberikan = $last_polio;
            }
            $riwayat->save();
        }
        //DPT 3
        if (in_array($im[7], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 8)->first();
            $riwayat->status = 'Sudah';
            if(!in_array($im[10], $done)){
                $riwayat->tgl_diberikan = $last_dpt;
            }
            $riwayat->save();
        }
        //Polio 4
        if (in_array($im[8], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 9)->first();
            $riwayat->tgl_diberikan = $last_polio;
            $riwayat->status = 'Sudah';
            $riwayat->save();
        }
        //MR
        if (in_array($im[9], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 10)->first();
            $riwayat->status = 'Sudah';
            if(!in_array($im[11], $done)){
                $riwayat->tgl_diberikan = $last_mr;
            }
            $riwayat->save();
        }
        // DPT Lanjutan
        if (in_array($im[10], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 11)->first();
            $riwayat->tgl_diberikan = $last_dpt;
            $riwayat->status = 'Sudah';
            $riwayat->save();
        }
        //MR Lanjutan
        if (in_array($im[11], $done)) {
            $riwayat = Riwayat::where('baby_id', $baby_id)->where('imunisasi_id', 12)->first();
           // $riwayat->tgl_diberikan = $last_mr;
            $riwayat->status = 'Sudah';
            $riwayat->save();
        }

    }
}
