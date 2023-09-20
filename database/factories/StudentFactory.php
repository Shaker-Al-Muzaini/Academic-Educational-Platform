<?php

namespace Database\Factories;

use App\Models\ClassRoom;
use App\Models\Grades;
use App\Models\ParentStudent;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    public function definition(): array
    {

        return [
            'Gender_id'=>random_int(1,2),
            'grade_id'=>Grades::factory()->create()->id,
            'class_room_id'=>ClassRoom::factory()->create()->id,
            'parent_student_id'=>7,
            'section_id'=>Section::factory()->create()->id,
            'name'=>$this->faker->sentence(),
            'password'=>$this->faker->password(),
            'email'=>$this->faker->email(),
            'address'=>$this->faker->address(),
        ];
    }
}
