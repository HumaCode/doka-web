<?php

namespace Database\Factories\Master;

use App\Models\Master\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Master\Kategori>
 */
class KategoriFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kategori::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(rand(3, 5), true);
        
        $icons = [
            'bi-people-fill', 'bi-tags-fill', 'bi-calendar3-fill', 'bi-images', 
            'bi-megaphone-fill', 'bi-flag-fill', 'bi-book-fill', 'bi-geo-alt-fill',
            'bi-star-fill', 'bi-heart-fill', 'bi-lightning-fill', 'bi-gear-fill'
        ];

        $gradients = [
            'linear-gradient(135deg,#4f46e5,#7c3aed)',
            'linear-gradient(135deg,#10b981,#06b6d4)',
            'linear-gradient(135deg,#f59e0b,#f97316)',
            'linear-gradient(135deg,#ec4899,#f472b6)',
            'linear-gradient(135deg,#06b6d4,#3b82f6)',
            'linear-gradient(135deg,#8b5cf6,#a78bfa)',
            'linear-gradient(135deg,#ef4444,#f87171)'
        ];

        return [
            'nama_kategori' => Str::title($name),
            'slug'          => Str::slug($name),
            'deskripsi'     => $this->faker->sentence(10),
            'icon'          => $this->faker->randomElement($icons),
            'warna'         => $this->faker->randomElement($gradients),
            'status'        => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
