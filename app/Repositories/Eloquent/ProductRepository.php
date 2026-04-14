<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private Product $model) {}

    public function getAll(array $filters = [])
    {
        $query = $this->model->newQuery();

        // =========================================
        // 🔍 SEARCH (nama & harga)
        // =========================================
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('nama', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('harga', 'like', '%' . $filters['search'] . '%');
            });
        }

        // =========================================
        // 🎯 FILTER EXACT
        // =========================================
        if (!empty($filters['nama'])) {
            $query->where('nama', $filters['nama']);
        }

        if (!empty($filters['harga'])) {
            $query->where('harga', $filters['harga']);
        }

        // =========================================
        // 🔎 FILTER LIKE
        // =========================================
        if (!empty($filters['nama_like'])) {
            $query->where('nama', 'like', '%' . $filters['nama_like'] . '%');
        }

        if (!empty($filters['harga_like'])) {
            $query->where('harga', 'like', '%' . $filters['harga_like'] . '%');
        }

        // =========================================
        // 🔽 SORTING
        // =========================================
        $allowedSorts = ['nama', 'harga', 'created_at'];

        if (!empty($filters['sort_by']) && in_array($filters['sort_by'], $allowedSorts)) {
            $query->orderBy(
                $filters['sort_by'],
                $filters['sort_direction'] ?? 'asc'
            );
        } else {
            $query->latest();
        }

        // =========================================
        // 📄 PAGINATION
        // =========================================
        return $query->paginate($filters['per_page'] ?? 10);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return $model;
    }

    public function delete(int $id): bool
    {
        $model = $this->model->find($id);

        return $model?->delete() ?? false;
    }
}
