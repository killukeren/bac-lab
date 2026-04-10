<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Superadmin BACLAB',
            'email' => 'superadmin@ensec.my.id',
            'role' => 'superadmin',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Admin BACLAB',
            'email' => 'admin@ensec.my.id',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Karyawan BACLAB',
            'email' => 'karyawan@ensec.my.id',
            'role' => 'karyawan',
            'password' => bcrypt('password'),
        ]);
    }
}
