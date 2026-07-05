<?php

namespace Database\Factories;

use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sucursal>
 */
class SucursalFactory extends Factory
{
    protected $model = Sucursal::class;

    public function definition(): array
    {
        return [
            'nombre' => 'Sucursal '.fake()->unique()->city(),
            'direccion' => fake()->address(),
            'telefono' => fake()->phoneNumber(),
            'horarios' => [
                'lunes-viernes' => '09:00-22:00',
                'sabado-domingo' => '10:00-23:00',
            ],
            'impuesto' => 18.00,
            'activo' => true,
        ];
    }
}
