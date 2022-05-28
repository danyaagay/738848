<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::with('shops')->get();
    }

    public function one($id)
    {
        return Product::with('shops')->find($id);
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

    public function search($request)
    {
        $product = Product::query();
        $product = $product->with('shops', function ($query) use ($request) {
            $data = $request->all();
            foreach ($data as $key => $value) {
                if ($key === 'api_token' || $key === 'name') continue;
                elseif ($key === 'sort') {
                    $sorts = explode(',', $request->sort);
                    if ($sorts) {
                        foreach ($sorts as $sort) {
                            $bind = explode(':', $sort);
                            $query->orderBy($bind[0], $bind[1]);
                        }
                    }
                } else {
                  $query->wherePivot($key, $value);
                }
            }
        });

        $names = explode(',', $request->name);
        if ($names) {
            foreach ($names as $name) {
                $product = $product->orWhere('name', $name);
            }
        }

        return $product->get();
    }
}