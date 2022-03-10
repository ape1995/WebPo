<?php

namespace Database\Factories;

use App\Models\CustomerProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_code' => $this->faker->word,
        'inventory_code' => $this->faker->word,
        'customer_class' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
