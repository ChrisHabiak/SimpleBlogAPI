<?php

namespace Database\Factories;

use App\Models\PasswordReset;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PasswordResetFactory extends Factory
{
    protected $model = PasswordReset::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'token' => $this->faker->unique()->sha256,
            'created_at' => Carbon::now(),
        ];
    }
}
