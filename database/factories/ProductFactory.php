<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $title = fake()->randomElement([
            'Ruana Pampa',
            'Poncho Andino',
            'Ruana Criolla',
            'Poncho Patagónico',
            'Ruana del Viento',
        ]);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 999),
            'description' => fake()->sentence(18),
            'price' => fake()->randomFloat(2, 45000, 120000),
            'stock' => fake()->numberBetween(5, 30),
            'image' => null,
            'is_active' => true,
        ];
    }
}
