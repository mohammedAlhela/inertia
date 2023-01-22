<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array 
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->unique()->name(),
            'last_name' => $this->faker->unique()->name(),
            'username' => $this->faker->unique()->name(),
            'phone' =>(string) $this->faker->unique()->numerify('##########'), 
        ]; 
    }


}
