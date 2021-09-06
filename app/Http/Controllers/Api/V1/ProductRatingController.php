<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRatingController extends Controller
{
    public function rate(Product $product, Request $request)
    {
        $this->validate($request, [
            'score' => 'required'
        ]);
        $user = $request->user();
        $user->rate($product, $request->get('score'));
        return new ProductResource($product);
    }
    public function unrate(Product $product, Request $request)
    {
        $user = $request->user();
        $user->unrate($product);
        return new ProductResource($product);
    }
}
