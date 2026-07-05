<?php

namespace App\Http\Requests\Producto;

use App\Models\Producto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('api')?->can('producto.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'precio' => ['required', 'numeric', 'min:0'],
            'imagen' => ['nullable', 'string', 'max:255'],
            'tipo' => ['nullable', Rule::in(Producto::TIPOS)],
            'modificadores' => ['nullable', 'array'],
            'modificadores.*.nombre' => ['required', 'string', 'max:255'],
            'modificadores.*.precio' => ['nullable', 'numeric', 'min:0'],
            'activo' => ['nullable', 'boolean'],
            'sucursales' => ['nullable', 'array'],
            'sucursales.*.sucursal_id' => ['required', 'integer', 'exists:sucursales,id'],
            'sucursales.*.precio' => ['nullable', 'numeric', 'min:0'],
            'sucursales.*.disponible' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'El precio base es obligatorio.',
            'tipo.in' => 'El tipo debe ser: plato, bebida o combo.',
        ];
    }
}
