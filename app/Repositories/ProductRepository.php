<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements ProductRepositoryInterface
{
    public function all($request)
    {
        $product = Product::query();
        return $product->with('shops', function ($query) use ($request) {
            $data = $request->all();
            foreach ($data as $key => $value) {
                if ($key === 'api_token') continue;
                elseif ($key === 'sort') {
                    $sorts = explode(',', $request->sort);
                    if ($sorts) {
                        foreach ($sorts as $sort) {
                            $query->orderBy($sort, 'desc');
                        }
                    }
                } else {
                  $query->wherePivot($key, $value);
                }
            }
        })->get();
    }

    public function one($request, $id)
    {
        $product = Product::query();
        return $product->with('shops', function ($query) use ($request) {
            $data = $request->all();
            foreach ($data as $key => $value) {
                if ($key === 'api_token') continue;
                elseif ($key === 'sort') {
                    $sorts = explode(',', $request->sort);
                    if ($sorts) {
                        foreach ($sorts as $sort) {
                            $query->orderBy($sort, 'desc');
                        }
                    }
                } else {
                  $query->wherePivot($key, $value);
                }
            }
        })->find($id);
    }

    public function attach($request, $productId, $shopId)
    {
        $product = Product::whereDoesntHave('shops', function (Builder $query) use ($shopId) {
            $query->where('shop_id', '=', $shopId);
        })->find($productId);

        if ($product) {
            $validated = $request->validate([
                'amount' => 'required|integer',
                'price' => 'required',
            ]);

            $product->shops()->attach($shopId,
                [
                    'amount' => $validated['amount'],
                    'price' => $validated['price'],
                ]
            );
            return Product::with('shops')->find($productId);
        } else {
            return response('The product already has this shop');
        }
    }

    public function detach($productId, $shopId)
    {
        $product = Product::findOrFail($productId);
        $product->shops()->detach($shopId);
        return Product::with('shops')->find($productId);
    }
}