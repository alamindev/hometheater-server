<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ProductHeader;
use App\Http\Resources\ServiceResource;

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
}
