<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Contracts\IProductRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Product repository
     *
     * @var IProductRepository
     */
    private $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display all Products.
     *
     * @return ProductResource
     */
    public function index()
    {
        return ProductResource::collection($this->productRepository->getAll());
    }

    /**
     * Store a newly created Product.
     *
     * @param ProductRequest
     * @return Product
     */
    public function store(ProductRequest $request)
    {
        return $this->productRepository->store($request);
    }

    /**
     * Update the specific Product.
     *
     * @param ProductRequest
     * @param Product
     * @return Product
     */
    public function update(ProductRequest $request, Product $product)
    {
        return $this->productRepository->update($request, $product);
    }

    /**
     * Remove the specified Product.
     *
     * @param Product
     */
    public function destroy(Product $product)
    {
        return $this->productRepository->delete($product);
    }
}
