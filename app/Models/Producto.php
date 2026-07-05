<?php

namespace App\Models;

use Database\Factories\ProductoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['categoria_id', 'nombre', 'descripcion', 'precio', 'imagen', 'tipo', 'modificadores', 'activo'])]
class Producto extends Model
{
    /** @use HasFactory<ProductoFactory> */
    use HasFactory;

    public const TIPOS = ['plato', 'bebida', 'combo'];

    protected $table = 'productos';

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'modificadores' => 'array',
            'activo' => 'boolean',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function sucursales(): BelongsToMany
    {
        return $this->belongsToMany(Sucursal::class, 'producto_sucursal')
            ->withPivot(['precio', 'disponible'])
            ->withTimestamps();
    }

    /**
     * Precio vigente para una sucursal: usa el override del pivote si existe,
     * de lo contrario el precio base.
     */
    public function precioParaSucursal(?int $sucursalId): float
    {
        if ($sucursalId !== null) {
            $pivot = $this->sucursales->firstWhere('id', $sucursalId)?->pivot;

            if ($pivot && $pivot->precio !== null) {
                return (float) $pivot->precio;
            }
        }

        return (float) $this->precio;
    }

    /**
     * Un producto está disponible en una sucursal salvo que el pivote diga lo contrario.
     */
    public function disponibleEnSucursal(?int $sucursalId): bool
    {
        if ($sucursalId === null) {
            return true;
        }

        $pivot = $this->sucursales->firstWhere('id', $sucursalId)?->pivot;

        return $pivot === null || (bool) $pivot->disponible;
    }
}
