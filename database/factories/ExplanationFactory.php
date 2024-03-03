<?php

namespace Database\Factories;

use App\Models\ClassRoom;
use App\Models\Grades;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Explanation>
 *
 */
class ExplanationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grade_id'=>Grades::factory()->create()->id,
            'class_room_id'=>ClassRoom::factory()->create()->id,
            'teacher_id'=>Teacher::factory()->create()->id,
            'name'=>$this->faker->sentence(),
            'notes'=>$this->faker->paragraph(),
        ];
    }
}
