<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Chirp;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chirp>
 */
class ChirpFactory extends Factory
{
    protected $model = Chirp::class;

    public function definition()
    {
        return [
            'message' => $this->faker->sentence, // Skapar ett random meddelande
            'user_id' => User::factory(),        // Kopplar till en ny användare
        ];
    }
}
