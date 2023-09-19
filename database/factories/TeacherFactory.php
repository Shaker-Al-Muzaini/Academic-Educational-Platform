<?php

namespace Database\Factories;

use App\Models\ClassRoom;
use App\Models\gender;
use App\Models\Grades;
use App\Models\specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        return [

            'Gender_id'=>random_int(1,2),
            'specialization_id'=>random_int(1,4),
            'name'=>$this->faker->sentence(),
            'password'=>$this->faker->password(),
            'email'=>$this->faker->email(),
            'address'=>$this->faker->address(),
            'joining_Date'=>$this->faker->date(),

        ];
    }
}
