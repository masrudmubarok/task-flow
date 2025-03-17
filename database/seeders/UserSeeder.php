<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'Barack',
            'last_name' => 'Ahmad',
            'email' => 'barack.ahmad@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'first_name' => 'Masrud',
            'last_name' => 'Mubarok',
            'email' => 'masrud.mubarok21@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}