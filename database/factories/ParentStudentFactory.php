<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParentStudent>
 */
class ParentStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email_mother'=>$this->faker->email(),
            'password_mother'=>$this->faker->password(),
            'parent_id'=>$this->faker->numberBetween(),
            'Name_Father'=>$this->faker->firstName(),
            'National_ID_Father'=>$this->faker->numberBetween(),
            'Phone_Father'=>$this->faker->phoneNumber(),
            'Job_Father'=>$this->faker->title(),
            'Nationality_Father_id'=>$this->faker->numberBetween(),
            'Address_Father'=>$this->faker->title(),
            'Name_Mother'=>$this->faker->firstName(),
            'National_ID_Mother'=>$this->faker->numberBetween(),
            'Phone_Mother'=>$this->faker->phoneNumber(),
            'Job_Mother'=>$this->faker->title(),
            'Nationality_Mother_id'=>$this->faker->numberBetween(),
            'Address_Mother'=>$this->faker->title(),
        ];
    }
}
