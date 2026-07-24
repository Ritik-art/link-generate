<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // DB::statement("
        //     INSERT INTO companies (id, name, created_at, updated_at)
        //     VALUES (1, 'Main Company', NOW(), NOW())
        // ");

        DB::statement("
            INSERT INTO users (company_id, name, email, password, role, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())
        ", [
            1,
            'Super Admin',
            'superadmin@mail.com',
            Hash::make('password'),
            'SuperAdmin'
        ]);
    }

}
