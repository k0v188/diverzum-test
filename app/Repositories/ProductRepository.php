<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Product;
use App\Contracts\IProductRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Collection;


class ProductRepository implements IProductRepository
{
    public function getAll(): Collection
    {
        return Product::with('coupon')->get();
    }

    public function find(int $id): Product
    {
        return Product::with('coupon')->find($id);
    }

    public function store(ProductRequest $request): Product
    {
        return Product::create(
            $request->all()
        );
    }

    public function update(ProductRequest $request, Product $product): ProductResource
    {
        $product->update(
            $request->only('company_name', 'company_url', 'name', 'coupon_id')
        );

        return new ProductResource($product);
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}
