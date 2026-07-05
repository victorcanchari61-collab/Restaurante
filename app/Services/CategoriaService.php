<?php

namespace App\Services;

use App\Models\Categoria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class CategoriaService
{
    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return Categoria::query()
            ->withCount('productos')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->paginate($perPage);
    }

    public function create(array $data): Categoria
    {
        return Categoria::create($data)->refresh();
    }

    public function update(Categoria $categoria, array $data): Categoria
    {
        $categoria->update($data);

        return $categoria->refresh();
    }

    public function delete(Categoria $categoria): void
    {
        try {
            $categoria->delete();
        } catch (QueryException) {
            throw ValidationException::withMessages([
                'categoria' => 'No se puede eliminar: la categoría tiene productos asociados. Mueve o elimina sus productos primero.',
            ]);
        }
    }
}
