<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function shop(Request $request, $productId, $shopId)
    {
        return $this->productRepository->attach($productId, $shopId, $request);
    }

    public function shopDestroy($productId, $shopId)
    {
        return $this->productRepository->detach($productId, $shopId);;
    }

    public function index(Request $request)
    {
        return $this->productRepository->all($request);
    }

    public function show(Request $request, $id)
    {
        return $this->productRepository->one($request, $id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        $product = Product::create($validated);
        return $product;
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'string',
        ]);
        $product->update($validated);
        return $product;
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
