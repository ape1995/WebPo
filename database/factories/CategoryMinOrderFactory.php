<?php

namespace Database\Factories;

use App\Models\CategoryMinOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryMinOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryMinOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category' => $this->faker->word,
        'minimum_order' => $this->faker->randomDigitNotNull,
        'start_date' => $this->faker->word,
        'end_date' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
