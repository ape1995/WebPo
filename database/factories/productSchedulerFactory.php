<?php

namespace Database\Factories;

use App\Models\productScheduler;
use Illuminate\Database\Eloquent\Factories\Factory;

class productSchedulerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = productScheduler::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->word,
        'inventory_code' => $this->faker->word,
        'customer_class' => $this->faker->word,
        'action_type' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
