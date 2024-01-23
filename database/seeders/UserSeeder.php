<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'                  => 'Fawwaz Hudzalfah Saputra',
            'email'                 => 'manusiacoding29@gmail.com',
            'email_verified_at'     => Carbon::now(),
            'password'              => Hash::make("password"),
            'remember_token'        => null,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
            'deleted_at'            => null
        ]);
    }
}
