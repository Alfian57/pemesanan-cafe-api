<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => \App\Models\Customer::factory(),
            'table_id' => \App\Models\Table::inRandomOrder()->first()->id,
            'cashier_id' => \App\Models\User::inRandomOrder()->first()->id,
            'order_status' => $this->faker->randomElement(['waiting-confirmation', 'pending', 'completed', 'cancelled']),
            'order_type' => $this->faker->randomElement(['dine-in', 'take-away']),
            'payment_method' => $this->faker->randomElement(['cash', 'via-web']),
            'payment_status' => $this->faker->randomElement(['unpaid', 'paid']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Order $order) {
            $order->orderItems()->saveMany(\App\Models\OrderItem::factory()->count(3)->make());
        });
    }
}
