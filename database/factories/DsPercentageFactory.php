<?php

namespace Database\Factories;

use App\Models\DsPercentage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DsPercentageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DsPercentage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_date' => $this->faker->word,
        'end_date' => $this->faker->word,
        'percentage' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
