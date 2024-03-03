<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ProductHeader;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ServiceCategoryResource; 
use App\Http\Resources\SingleServiceResource;
use App\Models\Review; 
use App\Models\ServiceCategory; 
use App\Http\Resources\ReviewServiceResource;
use App\Helpers\General\CollectionHelper;

class ProductController extends Controller
{
    
    
    public function Products()
    {
        $products =  Service::where('type', 1)->with('serviceImage')->get();
        $service_header = ProductHeader::select('title', 'description')->first();
        if (count($products) > 0) {
            return response()->json([
                'success' => true,
                'header' => $service_header,
                'products' => ServiceResource::collection($products),
            ], 200);
        }
        return response()->json([
            'errors' => [
                "message" => 'Products not found'
            ],
        ], 404);
    }

      /**
     *
     * fetch servies detials by id
     */
    public function ProductDetails($slug)
    { 
      $product =  Service::with('serviceImage', 'reviews')->where('type', 1)->where('slug', $slug)->first();
     
        if (!empty($product)) {
           $product_ids = Service::with('serviceImage')->where('type', 1)->where('id', '!=', $product->id)->where('category_id', $product->category_id)->pluck('id');
                if($product->suggestion){
                    $collection = collect($product_ids);
                    $product_ids  = $collection->concat(explode(',', $product->suggestion))->unique();
                    $suggests = Service::with('serviceImage')->where('type', 1)->whereIn('id', $product_ids)->get();
                }else{
                    $suggests = Service::with('serviceImage')->where('type', 1)->where('id', '!=', $product->id)->where('category_id', $product->category_id)->inRandomOrder()->get();
                }
            $reviews = [];
            $ids = $product->reviews->pluck('id');
            $reviews = Review::with('user', 'review_images')->whereIn('id', $ids)->latest()->limit(10)->get();
            $allreviews = Review::with('user')->whereIn('id', $ids)->get();
            $reviews = ReviewServiceResource::collection($reviews);
            $collection = collect($reviews);
            $total = $collection->count();
            $pageSize = 10;
            $reviews = CollectionHelper::paginate($collection, $total, $pageSize);
        }
        if (!empty($product)) {
            return response()->json([
                'success' => true,
                'product' => new SingleServiceResource($product),
                'suggests' => ServiceResource::collection($suggests),
                'reviews' => $reviews,
                'allreviews' => $allreviews,
            ], 200);
        }
        return response()->json([
            'errors' => [
                "message" => 'Service not found'
            ],
        ], 404);
    }
}
