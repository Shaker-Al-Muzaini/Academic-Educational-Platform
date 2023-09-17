<?php

namespace Database\Factories;

use App\Models\ClassRoom;
use App\Models\Client;
use App\Models\Grades;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
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
            'name'=>$this->faker->sentence(),
            'status'=>rand(1,3),
        ];
    }
}
