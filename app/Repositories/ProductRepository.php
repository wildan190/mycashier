<?php
// app/Repositories/Eloquent/EloquentProductRepository.php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::paginate(10);
    }

    public function getById($id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $attributes)
    {
        return Product::create($attributes);
    }

    public function update($id, array $attributes)
    {
        $product = $this->getById($id);
        $product->update($attributes);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->getById($id);
        $product->delete();
    }
}
