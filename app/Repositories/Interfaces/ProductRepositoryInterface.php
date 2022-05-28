<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function all($request);
    public function one($request, $id);
    public function attach($request, $productId, $shopId);
    public function detach($productId, $shopId);
}