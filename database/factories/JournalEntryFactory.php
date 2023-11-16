<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JournalEntry>
 */
class JournalEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
          'date' =>  $this->faker->date('Y-m-d'),
          'time' => $this->faker->time('H:i:s'),
          'receipt_number' => $this->faker->text(6),
          'currency_id' => factory('App\Currency', 3)->create()->id,
          'parity' => $this->faker->numberBetween(1, 3000),
          'security_level' => "low",
          'debit_total' => $this->faker->numberBetween(1000, 10000),
          'credit_total' => $this->faker->numberBetween(1000, 10000),
          'branch_id' => factory('App\Branch', 10)->create()->id,
          'notes' => $this->faker->text(40),
        ];
    }
}
