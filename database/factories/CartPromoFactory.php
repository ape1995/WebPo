<?php

namespace Database\Factories;

use App\Models\CartPromo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartPromoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CartPromo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'packet_code' => $this->faker->word,
        'qty' => $this->faker->randomDigitNotNull,
        'unit_price' => $this->faker->word,
        'total' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
