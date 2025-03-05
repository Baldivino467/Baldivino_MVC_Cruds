<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Create 50 students with predefined courses
        Student::factory()->count(50)->create([
            'student_id' => function() {
                static $counter = 1;
                return '2023' . str_pad($counter++, 3, '0', STR_PAD_LEFT);
            }
        ]);

       
    }
}
