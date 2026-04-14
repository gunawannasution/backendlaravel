<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{
    public function __construct(private ProductRepositoryInterface $repo) {}

    public function getAll(array $filters = [])
    {
        return $this->repo->getAll($filters);
    }

    public function getById(int $id)
    {
        $data = $this->repo->find($id);

        if (!$data) {
            throw new ModelNotFoundException();
        }

        return $data;
    }

    public function create(array $data)
    {
        $data['nama'] = trim($data['nama']);
        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id)
    {
        if (!$this->repo->delete($id)) {
            throw new ModelNotFoundException();
        }

        return true;
    }
}
