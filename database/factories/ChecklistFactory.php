<?php

namespace Database\Factories;

use App\Models\Checklist;
use App\Models\ChecklistGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use phpDocumentor\Reflection\Types\Null_;

class ChecklistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Checklist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
