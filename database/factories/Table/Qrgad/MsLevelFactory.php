<?php

namespace Database\Factories\Table\Qrgad;

use Illuminate\Database\Eloquent\Factories\Factory;

class MsLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => "LV00000005",
            'level' => "Admin",
            'created_at' => now(),
            'created_by' => "firda"
        ];
    }
}
