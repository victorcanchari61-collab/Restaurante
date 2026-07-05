<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sucursal\StoreSucursalRequest;
use App\Http\Requests\Sucursal\UpdateSucursalRequest;
use App\Http\Resources\SucursalResource;
use App\Models\Sucursal;
use App\Services\SucursalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SucursalController extends Controller
{
    public function __construct(
        protected SucursalService $sucursalService,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        abort_unless(auth('api')->user()?->can('sucursal.list'), 403);

        return SucursalResource::collection($this->sucursalService->list());
    }

    public function store(StoreSucursalRequest $request): JsonResponse
    {
        $sucursal = $this->sucursalService->create($request->validated());

        return (new SucursalResource($sucursal))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Sucursal $sucursale): SucursalResource
    {
        abort_unless(auth('api')->user()?->can('sucursal.list'), 403);

        return new SucursalResource($sucursale);
    }

    public function update(UpdateSucursalRequest $request, Sucursal $sucursale): SucursalResource
    {
        return new SucursalResource(
            $this->sucursalService->update($sucursale, $request->validated()),
        );
    }

    public function destroy(Sucursal $sucursale): JsonResponse
    {
        abort_unless(auth('api')->user()?->can('sucursal.delete'), 403);

        $this->sucursalService->delete($sucursale);

        return response()->json(['message' => 'Sucursal eliminada correctamente.']);
    }
}
