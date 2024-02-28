<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCategoryResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SingleServiceResource;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceHeader;
use Illuminate\Http\Request;
use App\Helpers\General\CollectionHelper;
use App\Http\Resources\ReviewServiceResource;

class ServiceController extends Controller
{
    /**
     *
     * start coding for fetch service list with category
     */

    public function ServiceLists()
    {
        $services =  ServiceCategory::with('services')->get();

        if (count($services) > 0) {
            return response()->json([
                'success' => true,
                'categories' => ServiceCategoryResource::collection($services),
            ], 200);
        }
        return response()->json([
            'errors' => [
                "message" => 'Service not found'
            ],
        ], 404);
    }
    /**
     *
     * start coding for fetch service header
     */

    public function ServiceHeader()
    {
        $service_header = ServiceHeader::select('service_title', 'service_details', 'service_btn_text', 'service_btn_link', 'image')->first();
        return response()->json([
            'success' => true,
            'header' => $service_header,
        ], 200);
    }
    /**
     *
     * fetch all services
     */
    public function Services()
    {
        $services =  Service::where('type', 0)->with('serviceImage')->get();
        $service_header = ServiceHeader::select('booking_title', 'booking_details')->first();
        if (count($services) > 0) {
            return response()->json([
                'success' => true,
                'header' => $service_header,
                'services' => ServiceResource::collection($services),
            ], 200);
        }
        return response()->json([
            'errors' => [
                "message" => 'Services not found'
            ],
        ], 404);
    }
    /**
     *
     * fetch servies detials by id
     */
    public function ServiceDetails($slug)
    {

      $service =  Service::with('serviceImage', 'reviews')->where('slug', $slug)->first();
        if (!empty($service)) {
           $service_ids = Service::with('serviceImage')->where('id', '!=', $service->id)->where('category_id', $service->category_id)->pluck('id');
                if($service->suggestion){
                    $collection = collect($service_ids);
                    $service_ids  = $collection->concat(explode(',', $service->suggestion))->unique();
                    $suggests = Service::with('serviceImage')->whereIn('id', $service_ids)->get();
                }else{
                    $suggests = Service::with('serviceImage')->where('id', '!=', $service->id)->where('category_id', $service->category_id)->inRandomOrder()->get();
                }
            $reviews = [];
            $ids = $service->reviews->pluck('id');
            $reviews = Review::with('user', 'review_images')->whereIn('id', $ids)->latest()->limit(10)->get();
            $allreviews = Review::with('user')->whereIn('id', $ids)->get();
            $reviews = ReviewServiceResource::collection($reviews);
            $collection = collect($reviews);
            $total = $collection->count();
            $pageSize = 10;
            $reviews = CollectionHelper::paginate($collection, $total, $pageSize);
        }
        if (!empty($service)) {
            return response()->json([
                'success' => true,
                'service' => new SingleServiceResource($service),
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
    /**
     *
     * fetch servies detials by id
     */
    public function FetchReviewPage($slug)
    {
        $service =  Service::with('reviews')->where('slug', $slug)->first();
        if (!empty($service)) {
            $reviews = [];
            $ids = $service->reviews->pluck('id');
            $reviews = Review::with('user', 'review_images')->whereIn('id', $ids)->latest()->limit(10)->get();
            $reviews = ReviewServiceResource::collection($reviews);
            $collection = collect($reviews);
            $total = $collection->count();
            $pageSize = 10;
            $reviews = CollectionHelper::paginate($collection, $total, $pageSize);
            return response()->json([
                'success' => true,
                'reviews' => $reviews,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
            ], 200);
        }
    }
    /**
     *
     * fetch reivew
     */
    public function Review($id)
    {
        $review = Review::with('user')->where('id', $id)->first();
        if (!empty($review)) {
            return response()->json([
                'success' => true,
                'review' => new ReviewServiceResource($review),
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
}
