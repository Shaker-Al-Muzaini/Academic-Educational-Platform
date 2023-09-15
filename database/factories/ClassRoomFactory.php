<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Grades;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassRoom>
 */
class ClassRoomFactory extends Factory
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
            'name_class'=>$this->faker->sentence(),
        ];
    }
}
