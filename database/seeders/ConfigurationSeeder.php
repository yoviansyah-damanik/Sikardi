<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Configuration;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            [
                'attribute' => 'app_name',
                'value' => config('app.name'),
                'description' => 'Nama aplikasi'
            ],
            [
                'attribute' => 'app_fullname',
                'value' => config('app.fullname'),
                'description' => 'Nama panjang aplikasi'
            ],
            [
                'attribute' => 'is_open',
                'value' => false,
                'description' => 'Buka pengisian KRS tanpa melihat jadwal pengisian KRS'
            ],
            [
                'attribute' => 'odd_semester',
                'value' => '01-02',
                'description' => 'Tanggal Masuk Semester Ganjil'
            ],
            [
                'attribute' => 'even_semester',
                'value' => '01-08',
                'description' => 'Tanggal Masuk Semester Genap'
            ],
            [
                'attribute' => 'start_date',
                'value' => '2024-01-01',
                'description' => 'Mulai pengisian KRS'
            ],
            [
                'attribute' => 'end_date',
                'value' => '2024-12-31',
                'description' => 'Akhir pengisian KRS'
            ],
            [
                'attribute' => 'cc_limit',
                'value' => 20,
                'description' => 'Batas jumlah SKS per semester'
            ],
            [
                'attribute' => 'name_of_department_head',
                'value' => 'Ucok Silaban, M.Kom.',
                'description' => 'Nama ketua program studi'
            ],
            [
                'attribute' => 'nidn_of_department_head',
                'value' => '1234567890',
                'description' => 'NIDN ketua program studi'
            ],
        ];

        $configs = collect($configs)
            ->map(fn ($config) => [...$config, ...['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]])
            ->toArray();

        Configuration::insert($configs);
    }
}
