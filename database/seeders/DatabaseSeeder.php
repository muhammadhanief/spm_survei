<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Dimension;
use App\Models\QuestionType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Operator']);
        Role::create(['name' => 'Dosen']);
        Role::create(['name' => 'Mahasiswa']);
        Role::create(['name' => 'Tenaga kependidikan']);
        Role::create(['name' => 'Pengguna lulusan']);
        Role::create(['name' => 'Lulusan']);

        // seeder untuk question type
        QuestionType::create([
            'name' => 'Tunggal',
        ]);
        QuestionType::create([
            'name' => 'Harapan',
        ]);
        QuestionType::create([
            'name' => 'Kenyataan',
        ]);

        // Seeder untuk dimensi
        Dimension::create([
            'name' => 'Keandalan',
        ]);
        Dimension::create([
            'name' => 'Daya Tangkap',
        ]);
        Dimension::create([
            'name' => 'Kepastian',
        ]);
        Dimension::create([
            'name' => 'Empati',
        ]);
        Dimension::create([
            'name' => 'Transparan',
        ]);
    }
}
