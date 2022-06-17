<?php

namespace Database\Factories;

use App\Models\PacketDiscount;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacketDiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PacketDiscount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'packet_code' => $this->faker->word,
        'packet_name' => $this->faker->word,
        'start_date' => $this->faker->word,
        'end_date' => $this->faker->word,
        'rbp_class' => $this->faker->word,
        'released_date' => $this->faker->word,
        'description' => $this->faker->text,
        'status' => $this->faker->word,
        'total' => $this->faker->randomDigitNotNull,
        'discount' => $this->faker->randomDigitNotNull,
        'grand_total' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
