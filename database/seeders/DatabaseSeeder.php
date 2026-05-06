<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $company = Company::firstOrCreate(['name' => 'Global HQ']);

        DB::table('users')->updateOrInsert(
            ['email' => 'superadmin@yopmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'company_id' => $company->id,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
