<?php

namespace Database\Factories;

use App\Models\BundlingGimmick;
use Illuminate\Database\Eloquent\Factories\Factory;

class BundlingGimmickFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BundlingGimmick::class;

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
        'package_type' => $this->faker->word,
        'nominal' => $this->faker->randomDigitNotNull,
        'free_qty' => $this->faker->randomDigitNotNull,
        'free_descr' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
