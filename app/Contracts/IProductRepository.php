<?php

namespace App\Contracts;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Collection;



interface IProductRepository
{
    /**
     * Get all Product
     *
     * @return Collection
     */
    public function getAll(): Collection;


    /**
     * Find a Product
     *
     * @param int $id
     * @return Product
     */
    public function find(int $id): Product;

    /**
     * Store Product
     *
     * @param ProductRequest
     * @return Product
     */
    public function store(ProductRequest $request): Product;

    /**
     * update specific Product
     *
     * @param ProductRequest
     * @param Product
     * @return ProductResource
     */
    public function update(ProductRequest $request, Product $product): ProductResource;

    /**
     * delete specific Product
     *
     * @param Product
     */
    public function delete(Product $product);
}
