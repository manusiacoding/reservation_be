<?php

namespace Database\Seeders;

use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = [];

        for ($i=0; $i < 10; $i++) { 
            $data = [
                'name'          => 'Meja' . ($i + 1),
                'status'        => false,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ];

            array_push($arr, $data);
        }

        Table::insert($arr);
    }
}
