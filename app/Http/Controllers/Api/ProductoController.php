<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producto\StoreProductoRequest;
use App\Http\Requests\Producto\UpdateProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use App\Services\ProductoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductoController extends Controller
{
    public function __construct(
        protected ProductoService $productoService,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        abort_unless(auth('api')->user()?->can('producto.list'), 403);

        return ProductoResource::collection($this->productoService->list());
    }

    public function store(StoreProductoRequest $request): JsonResponse
    {
        $producto = $this->productoService->create($request->validated());

        return (new ProductoResource($producto))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Producto $producto): ProductoResource
    {
        abort_unless(auth('api')->user()?->can('producto.list'), 403);

        return new ProductoResource($producto->load(['categoria', 'sucursales']));
    }

    public function update(UpdateProductoRequest $request, Producto $producto): ProductoResource
    {
        return new ProductoResource(
            $this->productoService->update($producto, $request->validated()),
        );
    }

    public function destroy(Producto $producto): JsonResponse
    {
        abort_unless(auth('api')->user()?->can('producto.delete'), 403);

        $this->productoService->delete($producto);

        return response()->json(['message' => 'Producto eliminado correctamente.']);
    }
}
