<?php

namespace Database\Factories;

use App\Enums\ServiceEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            "transaction_date" => $this->faker->dateTimeBetween('-1 weeks', '1 weeks')->format("Y-m-d"),
            "description"      => $this->faker->randomElement(ServiceEnum::values()),
            "status"           => $this->faker->randomElement(StatusEnum::values()),
            "amount"           => ($this->faker->numberBetween(5, 200) * 1000),
        ];
    }
}
