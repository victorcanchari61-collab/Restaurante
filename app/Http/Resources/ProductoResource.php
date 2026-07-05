<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Producto
 */
class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'categoria_id' => $this->categoria_id,
            'categoria' => $this->whenLoaded('categoria', fn () => [
                'id' => $this->categoria->id,
                'nombre' => $this->categoria->nombre,
            ]),
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => (float) $this->precio,
            'imagen' => $this->imagen,
            'tipo' => $this->tipo,
            'modificadores' => $this->modificadores ?? [],
            'activo' => $this->activo,
            'sucursales' => $this->whenLoaded('sucursales', fn () => $this->sucursales->map(fn ($sucursal) => [
                'sucursal_id' => $sucursal->id,
                'nombre' => $sucursal->nombre,
                'precio' => $sucursal->pivot->precio !== null ? (float) $sucursal->pivot->precio : null,
                'disponible' => (bool) $sucursal->pivot->disponible,
            ])),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
