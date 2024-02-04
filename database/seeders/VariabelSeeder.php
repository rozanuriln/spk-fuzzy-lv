<?php

namespace Database\Seeders;

use App\Models\Variabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'variabel' => 'Usia',
                'kode' => 'K1',
            ],
            [
                'variabel' => 'Pendidikan',
                'kode' => 'K2',
            ],
            [
                'variabel' => 'Pengalaman Kerja',
                'kode' => 'K3',
            ],
            [
                'variabel' => 'Keterampilan',
                'kode' => 'K4',
            ],
            [
                'variabel' => 'Seritifikat Pendukung',
                'kode' => 'K5',
            ],
        ];

        foreach ($data as $value) {
            Variabel::create($value);
        }
    }
}
