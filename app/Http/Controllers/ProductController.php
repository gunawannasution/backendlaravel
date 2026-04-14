<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function index(ProductIndexRequest $request)
    {
        return new ProductCollection(
            $this->service->getAll($request->validated())
        );
    }

    public function show($id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->service->getById((int) $id)
        ]);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->service->create($request->validated())
        ], 201);
    }

    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->service->update((int) $id, $request->validated())
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->service->delete((int) $id);

        return response()->json([
            'success' => true
        ]);
    }
}
