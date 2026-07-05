<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct(
        protected ProductoService $productoService,
    ) {}

    /**
     * Menú armado para el POS: categorías activas con productos activos,
     * precio y disponibilidad resueltos para la sucursal indicada.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'sucursal_id' => ['nullable', 'integer', 'exists:sucursales,id'],
        ]);

        $sucursalId = $request->filled('sucursal_id')
            ? (int) $request->input('sucursal_id')
            : null;

        return response()->json([
            'data' => $this->productoService->menu($sucursalId),
        ]);
    }
}
