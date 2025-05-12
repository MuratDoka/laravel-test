<?php
namespace App\Services;

class PriceCalculator
{
    protected float $margin;
    protected float $shipping;

    public function __construct()
    {
        // resolved once per request
        $this->margin = config('coffee.profit_margin');
        $this->shipping = config('coffee.shipping_cost');
    }

    /**
     * @param  int|float  $quantity
     * @param  int|float  $unitCost
     * @return array{cost: float, selling_price: float}
     */
    public function calculate(float $quantity, float $unitCost): array
    {
        $cost  = $quantity * $unitCost;
        $price = $cost / (1 - $this->margin) + $this->shipping;

        return [
            'cost'           => round($cost, 2),
            'selling_price'  => round($price, 2),
        ];
    }
}
