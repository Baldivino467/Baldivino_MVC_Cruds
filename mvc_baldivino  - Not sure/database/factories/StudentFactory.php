<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courses = ['BSIT', 'BSCS', 'BSIS', 'BSEMC'];
        $yearLevels = ['1st Year', '2nd Year', '3rd Year', '4th Year'];
        
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'year_level' => $this->faker->randomElement($yearLevels),
            'course' => $this->faker->randomElement($courses),
        ];
    }
}
