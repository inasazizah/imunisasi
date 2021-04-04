<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=[
            [
                'nama'=>'Inas',
                'email'=>'azizah@gmail.com',
                'nomor_whatsapp'=>'085157834661',
                'password'=>bcrypt('sembilan'),
            ]
        ];

        foreach ($users as $key => $value) {
            User::create($value);
        }
    }
}
