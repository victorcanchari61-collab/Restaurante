<?php

namespace App\Http\Requests\Sucursal;

use Illuminate\Foundation\Http\FormRequest;

class StoreSucursalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('api')?->can('sucursal.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'horarios' => ['nullable', 'array'],
            'impuesto' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la sucursal es obligatorio.',
            'impuesto.numeric' => 'El impuesto debe ser un número.',
            'impuesto.max' => 'El impuesto no puede ser mayor a :max %.',
        ];
    }
}
