<?php

namespace App\Services;

use App\Models\Sucursal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SucursalService
{
    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return Sucursal::query()
            ->orderBy('nombre')
            ->paginate($perPage);
    }

    public function create(array $data): Sucursal
    {
        // refresh() para devolver también los valores por defecto de la BD (ej. activo)
        return Sucursal::create($data)->refresh();
    }

    public function update(Sucursal $sucursal, array $data): Sucursal
    {
        $sucursal->update($data);

        return $sucursal->refresh();
    }

    public function delete(Sucursal $sucursal): void
    {
        $sucursal->delete();
    }
}
