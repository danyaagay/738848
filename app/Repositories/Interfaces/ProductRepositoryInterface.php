<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function all();
    public function one($id);
    public function attach($request, $productId, $shopId);
    public function detach($productId, $shopId);
    public function search($request);
}