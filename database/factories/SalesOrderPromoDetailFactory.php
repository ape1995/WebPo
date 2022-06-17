<?php

namespace Database\Factories;

use App\Models\SalesOrderPromoDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesOrderPromoDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrderPromoDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sales_order_promo_id' => $this->faker->randomDigitNotNull,
        'packet_code' => $this->faker->randomDigitNotNull,
        'qty' => $this->faker->randomDigitNotNull,
        'unit_price' => $this->faker->word,
        'total' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
