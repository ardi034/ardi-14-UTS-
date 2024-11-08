<?php

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run()
    {
        Student::create([
            'nama' => 'John Doe',
            'nim' => '123456789',
            'kelas' => '10A'
        ]);

        // Anda bisa menambahkan lebih banyak data di sini
    }
}
