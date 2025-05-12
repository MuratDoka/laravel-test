<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 20);
        $unitCost = $this->faker->randomFloat(2, 2, 10);
        $cost = $quantity * $unitCost;
        $sellingPrice = ($cost / (1 - 0.25)) + 10;

        return [
            'user_id' => User::first()?->id ?? User::factory(),
            'quantity' => $quantity,
            'unit_cost' => $unitCost,
            'cost' => $cost,
            'selling_price'  => round($sellingPrice, 2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
