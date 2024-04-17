<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Admin::factory(1000)->create();
        // \App\Models\User::factory(100)->create();

        // User::create([
        //     'name' => 'phanmanhhao',
        //     'phone' => '0989449675',
        //     'email' => 'phanhaost@gmail.com',
        //     'password' => Hash::make('123456'),
        //     'is_active' => 1
        // ]);
    }
}
