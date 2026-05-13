<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@legadopato.com'],
            [
                'name' => 'Camila Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $category = Category::query()->updateOrCreate(
            ['slug' => 'ruanas-clasicas'],
            ['name' => 'Ruanas Clásicas']
        );

        $products = [
            [
                'title' => 'Ruana Pampa',
                'description' => 'Ruana de lana natural tejida a mano, ideal para días frescos y noches de campo.',
                'price' => 84500,
                'stock' => 10,
            ],
            [
                'title' => 'Poncho Andino',
                'description' => 'Poncho artesanal con trama tradicional andina, abrigo noble y liviano para uso diario.',
                'price' => 92900,
                'stock' => 12,
            ],
            [
                'title' => 'Ruana Criolla',
                'description' => 'Diseño clásico argentino en fibras seleccionadas, pensado para durar generaciones.',
                'price' => 78900,
                'stock' => 14,
            ],
            [
                'title' => 'Poncho Patagónico',
                'description' => 'Poncho cálido de textura suave, inspirado en la identidad del sur y la tradición textil.',
                'price' => 97500,
                'stock' => 11,
            ],
        ];

        foreach ($products as $data) {
            $product = Product::query()->updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'image' => null,
                    'is_active' => true,
                ]
            );

            $product->categories()->syncWithoutDetaching([$category->id]);
        }
    }
}
