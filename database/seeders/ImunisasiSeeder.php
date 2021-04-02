<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Imunisasi;

class ImunisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imunisasis = [
            [
               'jenis'=>'HB0',
            ],
            [
                'jenis'=>'BCG',
            ],
            [
                'jenis'=>'Polio 1',
            ],
            [
                'jenis'=>'DPT-HB-Hib 1',
            ],
            [
                'jenis'=>'Polio 2',
            ],
            [
                'jenis'=>'DPT-HB-Hib 2',
            ],
            [
                'jenis'=>'Polio 3',
            ],
            [
                'jenis'=>'DPT-HB-Hib 3',
            ],
            [
                'jenis'=>'Polio 4',
            ],
            [
                'jenis'=>'MR',
            ],
            [
                'jenis'=>'DPT-HB-Hib Lanjutan',
            ],
            [
                'jenis'=>'MR Lanjutan',
            ],
        ];

        foreach ($imunisasis as $key => $value) {
            Imunisasi::create($value);
        }
    }
}
