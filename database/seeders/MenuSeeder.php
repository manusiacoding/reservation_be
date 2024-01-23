<?php

namespace Database\Seeders;

use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name'          => 'Nasi Goreng',
                'price'         => '10000',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'Nasi Goreng Spesial',
                'price'         => '15000',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'Mie Goreng Spesial',
                'price'         => '15000',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'Mie Goreng Spesial',
                'price'         => '15000',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'Es Jeruk',
                'price'         => '8000',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]
        ];

        Menu::insert($data);
    }
}
