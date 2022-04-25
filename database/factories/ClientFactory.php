<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
           'name' => $this->faker->name(),
           'last_name' => $this->faker->name(),
           'document_type_id' => $this->faker->randomElement([1, 2]),
           'document_number'  => $this->faker->numerify('########')
        ];
    }
}
