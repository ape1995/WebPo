<?php

namespace Database\Factories;

use App\Models\PacketDiscountDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacketDiscountDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PacketDiscountDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'packet_discount_id' => $this->faker->randomDigitNotNull,
        'inventory_code' => $this->faker->word,
        'inventory_name' => $this->faker->word,
        'qty' => $this->faker->randomDigitNotNull,
        'unit_price' => $this->faker->randomDigitNotNull,
        'total_amount' => $this->faker->randomDigitNotNull,
        'discount_percentage' => $this->faker->word,
        'discount_amount' => $this->faker->word,
        'amount' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
