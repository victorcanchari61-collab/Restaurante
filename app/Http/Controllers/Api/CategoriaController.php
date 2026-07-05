<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categoria\StoreCategoriaRequest;
use App\Http\Requests\Categoria\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use App\Services\CategoriaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoriaController extends Controller
{
    public function __construct(
        protected CategoriaService $categoriaService,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        abort_unless(auth('api')->user()?->can('categoria.list'), 403);

        return CategoriaResource::collection($this->categoriaService->list());
    }

    public function store(StoreCategoriaRequest $request): JsonResponse
    {
        $categoria = $this->categoriaService->create($request->validated());

        return (new CategoriaResource($categoria))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Categoria $categoria): CategoriaResource
    {
        abort_unless(auth('api')->user()?->can('categoria.list'), 403);

        return new CategoriaResource($categoria->load('productos'));
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): CategoriaResource
    {
        return new CategoriaResource(
            $this->categoriaService->update($categoria, $request->validated()),
        );
    }

    public function destroy(Categoria $categoria): JsonResponse
    {
        abort_unless(auth('api')->user()?->can('categoria.delete'), 403);

        $this->categoriaService->delete($categoria);

        return response()->json(['message' => 'Categoría eliminada correctamente.']);
    }
}
