<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\EnquiryServiceContract;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(EnquiryServiceContract $enquiryService): JsonResponse
    {
        $products = Product::getPaginatedProducts();

        $productPrices = $enquiryService->getProductPrices($products->pluck('id'));

        $products->setCollection(
            $products->getCollection()
                ->each(function (Product $product) use ($productPrices): void {
                    $product['price'] = $productPrices[$product->id];
                })
        );

        return response()->json(['products' => $products]);
    }
}
