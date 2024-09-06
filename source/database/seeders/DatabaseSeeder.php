<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            MobilitiesTableSeeder::class,
            HomeInstitutionsTableSeeder::class,
            DocumentTypesTableSeeder::class,
            DocumentTypeLinksTableSeeder::class,
            MobilitiesDocumentTypesTableSeeder::class,
            SemesterTableSeeder::class,
            ContestSeeder::class
        ]);
    }
}
