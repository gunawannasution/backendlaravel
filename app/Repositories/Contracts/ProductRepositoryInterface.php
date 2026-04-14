<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function getAll(array $filters = []);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
}
