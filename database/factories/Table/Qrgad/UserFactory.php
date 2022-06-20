<?php

namespace Database\Factories\Table\Qrgad;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => '012100'. mt_rand(2,100),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'nama' => $this->faker->name(),
            'jabatan' =>$this->faker->jobTitle(),
            'divisi' => $this->faker->jobTitle(),
            'departemen' => $this->faker->jobTitle(),
            'level' => 'LV0000000'. mt_rand(1,4),
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda",
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                
            ];
        });
    }
}
