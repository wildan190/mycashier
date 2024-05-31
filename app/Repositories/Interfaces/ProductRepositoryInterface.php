<?php
// app/Repositories/Interfaces/ProductRepositoryInterface.php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function create(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);
}
