<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class RulesController extends Controller
{
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function aturan()
    {
        $im = ["HB0", "BCG", "Polio 1", "DPT-HB-Hib 1", "Polio 2", "DPT-HB-Hib 2", "Polio 3", "DPT-HB-Hib 3", "Polio 4", "MR", "DPT-HB-Hib Lanjutan", "Campak Lanjutan"];

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
        $ttl = new DateTime($_POST['ttl']);
        $usia = $_POST['usia'];
        $bb = $_POST['bb'];
        $done = $_POST['done'];
        $last_polio = new DateTime($_POST['last_polio']);
        $last_dpt = new DateTime($_POST['last_dpt']);
        $last_mr = new DateTime($_POST['last_mr']);
        $now = new DateTime();


        function check($all, $search_this) {
            return count(array_intersect($search_this, $all)) == count($search_this);
        }

        //berat badan tidak mencukupi
        if ($bb < 2) {
            echo "Tidak imunisasi karena berat badan tidak sampai 2 kg";
        }
        else {
            //HB0
            if ($usia == 0 && !in_array($im[0], $done)) {
                $tgl_imunisasi = clone $ttl;
                $tgl_imunisasi = $tgl_imunisasi->format('d-m-Y');
                echo "Imunisasi $im[0] pada tanggal $tgl_imunisasi <br>";
            }
            //BCG
            if ($usia == 1 && !in_array($im[1], $done)) {
                $tgl_imunisasi = clone $ttl;
                $tgl_imunisasi->add($interval);
                $tgl_imunisasi = $tgl_imunisasi->format('d-m-Y');
                echo "Imunisasi $im[1] pada tanggal $tgl_imunisasi <br>";
            
            } elseif ($usia >= 1 && $usia <= 3 && !in_array($im[1], $done)) {
                $tgl_imunisasi = clone $now;
                $tgl_imunisasi = $tgl_imunisasi->format('d-m-Y');
                echo "Imunisasi $im[1] pada tanggal $tgl_imunisasi <br>";
            }
            //Polio 1
            if ($usia == 1 && !in_array($im[2], $done)) {
                $tgl_imunisasi = clone $ttl;
                $tgl_imunisasi = $tgl_imunisasi->add($interval)->format('d-m-Y');
                echo "Imunisasi $im[2] pada tanggal $tgl_imunisasi <br>";
            } elseif ($usia >= 1 && $usia <= 24 && !in_array($im[2], $done)) {
                $tgl_imunisasi = clone $now;
                $tgl_imunisasi = $tgl_imunisasi->format('d-m-Y');
                echo "Imunisasi $im[2] pada tanggal $tgl_imunisasi <br>";
            }
            //Polio 2
            if ($usia == 2 && in_array($im[2], $done) && !in_array($im[4], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_polio;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval2);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[4] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[4] pada tanggal $tgl_imunisasi2 <br>";
                }
            } elseif ($usia >= 2 && $usia <= 24 && in_array($im[2], $done) && !in_array($im[4], $done)) {
                $tgl_imunisasi1 = clone $last_polio;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[4] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[4] pada tanggal $tgl_imunisasi2 <br>";
                }
            }
            //Polio 3
            if ($usia == 3 && in_array($im[4], $done) && !in_array($im[6], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_polio;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval3);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[6] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[6] pada tanggal $tgl_imunisasi2 <br>";
                }
            } elseif ($usia >= 3 && $usia <= 24 && in_array($im[4], $done) && !in_array($im[6], $done)) {
                $tgl_imunisasi1 = clone $last_polio;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[6] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[6] pada tanggal $tgl_imunisasi2 <br>";
                }
            }
            //Polio 4
            if ($usia == 4 && in_array($im[6], $done) && !in_array($im[8], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_polio;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval4);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[8] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[8] pada tanggal $tgl_imunisasi2 <br>";
                }
            } elseif ($usia >= 4 && $usia <= 24 && in_array($im[6], $done) && !in_array($im[8], $done)) {
                $tgl_imunisasi1 = clone $last_polio;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[8] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[8] pada tanggal $tgl_imunisasi2 <br>";
                }
            }
            //DPT-HB-Hib 1
            if ($usia == 2 && !in_array($im[3], $done)) {
                $tgl_imunisasi = clone $ttl;
                $tgl_imunisasi = $tgl_imunisasi->add($interval2)->format('d-m-Y');
                echo "Imunisasi $im[3] pada tanggal $tgl_imunisasi <br>";
            } elseif ($usia >= 2 && $usia <= 24 && !in_array($im[2], $done)) {
                $tgl_imunisasi = clone $now;
                $tgl_imunisasi = $tgl_imunisasi->format('d-m-Y');
                echo "Imunisasi $im[3] pada tanggal $tgl_imunisasi <br>";
            }
            //DPT-HB-Hib 2
            if ($usia == 3 && in_array($im[3], $done) && !in_array($im[5], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_dpt;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval3);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[5] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[5] pada tanggal $tgl_imunisasi2 <br>";
                }
            } elseif ($usia >= 3 && $usia <= 24 && in_array($im[3], $done) && !in_array($im[5], $done)) {
                $tgl_imunisasi1 = clone $last_dpt;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[5] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[5] pada tanggal $tgl_imunisasi2 <br>";
                }
            }
            //DPT-HB-Hib 3
            if ($usia == 4 && in_array($im[5], $done) && !in_array($im[7], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_dpt;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval4);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[7] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[7] pada tanggal $tgl_imunisasi2 <br>";
                }
            } elseif ($usia >= 4 && $usia <= 24 && in_array($im[5], $done) && !in_array($im[7], $done)) {
                $tgl_imunisasi1 = clone $last_dpt;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[7] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[7] pada tanggal $tgl_imunisasi2 <br>";
                }
            }
            //DPT-HB-Hib Lanjutan
            if ($usia > 9 && $usia <= 18 && in_array($im[7], $done) && !in_array($im[10], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_dpt;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval18);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[10] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[10] pada tanggal $tgl_imunisasi2 <br>";
                }
            } elseif ($usia >= 18 && $usia <= 24 && in_array($im[7], $done) && !in_array($im[10], $done)) {
                $tgl_imunisasi1 = clone $last_dpt;
                $tgl_imunisasi2 = clone $now;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[10] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[10] pada tanggal $tgl_imunisasi2 <br>";
                }
            }
            //MR
            if ($usia > 4 && $usia <= 9 &&  !in_array($im[9], $done)) {
                $tgl_imunisasi = clone $ttl;
                $tgl_imunisasi = $tgl_imunisasi->add($interval9)->format('d-m-Y');
                echo "Imunisasi $im[9] pada tanggal $tgl_imunisasi <br>";
            } elseif ($usia >= 9 && $usia <= 24 && !in_array($im[9], $done)) {
                $tgl_imunisasi = clone $now;
                $tgl_imunisasi = $tgl_imunisasi->format('d-m-Y');
                echo "Imunisasi $im[9] pada tanggal $tgl_imunisasi <br>";
            }
            //MR Lanjutan
            if ($usia >= 19 && $usia <= 24 && in_array($im[9], $done) && !in_array($im[11], $done)) {
                $tgl_imunisasi1 = clone $ttl;
                $tgl_imunisasi2 = clone $last_mr;
                $tgl_imunisasi1 = $tgl_imunisasi1->add($interval24);
                $tgl_imunisasi2 = $tgl_imunisasi2->add($interval6);
                if ($tgl_imunisasi1 > $tgl_imunisasi2) {
                    $tgl_imunisasi1 = $tgl_imunisasi1->format('d-m-Y');
                    echo "Imunisasi $im[11] pada tanggal $tgl_imunisasi1 <br>";
                }
                else {
                    $tgl_imunisasi2 = $tgl_imunisasi2->format('d-m-Y');
                    echo "Imunisasi $im[11] pada tanggal $tgl_imunisasi2 <br>";
                }
            }
        }   
    }
}