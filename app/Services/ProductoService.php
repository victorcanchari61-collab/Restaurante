<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductoService
{
    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return Producto::query()
            ->with(['categoria', 'sucursales'])
            ->orderBy('nombre')
            ->paginate($perPage);
    }

    public function create(array $data): Producto
    {
        $producto = Producto::create($data)->refresh();

        $this->syncSucursales($producto, $data['sucursales'] ?? null);

        return $producto->load(['categoria', 'sucursales']);
    }

    public function update(Producto $producto, array $data): Producto
    {
        $producto->update($data);

        $this->syncSucursales($producto, $data['sucursales'] ?? null);

        return $producto->refresh()->load(['categoria', 'sucursales']);
    }

    public function delete(Producto $producto): void
    {
        $producto->delete();
    }

    /**
     * Menú público para el POS: categorías activas (en orden) con sus productos
     * activos y el precio resuelto para la sucursal indicada.
     */
    public function menu(?int $sucursalId = null): Collection
    {
        return Categoria::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->with(['productos' => fn ($query) => $query->where('activo', true)->with('sucursales')->orderBy('nombre')])
            ->get()
            ->map(fn (Categoria $categoria) => [
                'id' => $categoria->id,
                'nombre' => $categoria->nombre,
                'imagen' => $categoria->imagen,
                'productos' => $categoria->productos
                    ->filter(fn (Producto $producto) => $producto->disponibleEnSucursal($sucursalId))
                    ->map(fn (Producto $producto) => [
                        'id' => $producto->id,
                        'nombre' => $producto->nombre,
                        'descripcion' => $producto->descripcion,
                        'tipo' => $producto->tipo,
                        'imagen' => $producto->imagen,
                        'precio' => $producto->precioParaSucursal($sucursalId),
                        'modificadores' => $producto->modificadores ?? [],
                    ])
                    ->values(),
            ])
            ->filter(fn (array $categoria) => $categoria['productos']->isNotEmpty())
            ->values();
    }

    private function syncSucursales(Producto $producto, ?array $sucursales): void
    {
        if ($sucursales === null) {
            return;
        }

        $pivotData = collect($sucursales)->mapWithKeys(fn (array $item) => [
            $item['sucursal_id'] => [
                'precio' => $item['precio'] ?? null,
                'disponible' => $item['disponible'] ?? true,
            ],
        ]);

        $producto->sucursales()->sync($pivotData);
    }
}
