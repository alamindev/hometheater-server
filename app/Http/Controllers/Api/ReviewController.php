<?php

namespace App\Http\Controllers\Api;

use App\Helpers\General\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingReviewResource;
use App\Http\Resources\ReviewsResource;
use App\Models\Activity;
use App\Models\Order;
use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ReviewController extends Controller
{

    public function Reviews($id)
    {
        if (!empty($id)) {
            $reviews = Review::with('service', 'order')->where('user_id', $id)->latest()->get();
            $reviews = ReviewsResource::collection($reviews);
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

    public function OrderServices($id)
    {
        if (!empty($id)) {
            $order = Order::with('services')->where('id', $id)->first();
            return response()->json([
                'success' => true,
                'order_services' => new BookingReviewResource($order),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
            ], 200);
        }
    }


    public function Reviewstore(Request $request)
    {

        if ($request->order_id) {
            $review = new Review();
            $review->rating = $request->rating;
            $review->details = $request->text;
            $review->user_id = $request->user_id;
            $review->service_id = $request->service_id;
            $review->order_id = $request->order_id;
            $review->save();

            $service = Service::where('id', $request->service_id)->select('id', 'slug')->first();
            $activity = new Activity();
            $activity->user_id  = $request->user_id;
            $activity->type  = 'review';
            $activity->text  = strip_tags(Str::words($request->text, 5));
            $activity->link  = '/booking/' . $service->slug . '?tab=review';
            $activity->save();



            if (count($request->images) > 0) {
                $images = collect($request->images);
                foreach ($images as $key => $img) {
                    if($service->id == $img['service_id']){
                        if (!empty($img['title']) && !empty($img['image'])) {
                            $image_parts = explode(";base64,", $img['image']);
                            $image_type_aux = explode("image/", $image_parts[0]);
                            $image_type = $image_type_aux[1];
                            $image_base64 = base64_decode($image_parts[1]);
                            $random = Str::random('20') . time();
                            $name = $random . '.' . $image_type;
                            $image = Image::make($image_base64)->encode('jpg');
                            $folder = public_path('uploads/users/' . $review->user_id);
                            if (!\File::exists($folder)) {
                                    mkdir($folder, 0755, true);
                            }
                            $image->save('uploads/users/' . $review->user_id . '/' . $name, 30);

                            $review_img = new ReviewImage();
                            $review_img->review_id = $review->id;
                            $review_img->title = $img['title'];
                            $review_img->description = $img['description'];
                            $review_img->image = "uploads/users/$review->user_id/$name";
                            $review_img->save();
                        }
                    }
                }
            }




            $order = Order::with('services')->where('id', $request->order_id)->first();
            return response()->json([
                'success' => true,
                'order_services' => new BookingReviewResource($order),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
            ], 200);
        }
    }
    /**
     * fetch edit review
     */
    public function editReview($id)
    {
        $order = Review::with('review_images')->where('id', $id)->first();
        if ($order) {
            return response()->json([
                'success' => true,
                'review' => $order,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
            ], 200);
        }
    }

    /**
     * show details of reviews
     */
    public function detailsReview($id)
    {
        $order = Review::with('service', 'review_images')->where('id', $id)->first();
        if ($order) {
            return response()->json([
                'success' => true,
                'review' => $order,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
            ], 200);
        }
    }
    /**
     * update review
     *
     */
    public function updateReview(Request $request)
    {
        if ($request->id) {
            $review = Review::find($request->id);
            $review->rating = $request->rating;
            $review->details = $request->text;
            $review->save();
            if (count($request->images) > 0) {
                $images = collect($request->images);
                foreach ($images as $key => $img) {
                    if($review->service_id == $img['service_id']){
                        if (!empty($img['title']) && !empty($img['image'])) {
                            $review_img =   ReviewImage::find($img['id']);
                            if (empty($review_img)) {
                                $review_img = new ReviewImage();
                            }
                            if (strpos($img['image'], ';base64') !== false) {
                                $image_parts = explode(";base64,", $img['image']);
                                $image_type_aux = explode("image/", $image_parts[0]);
                                $image_type = $image_type_aux[1];
                                $image_base64 = base64_decode($image_parts[1]);
                                $random = Str::random('20') . time();
                                $name = $random . '.' . $image_type;
                                $image = Image::make($image_base64)->encode('jpg');
                                $folder = public_path('uploads/users/' . $review->user_id);
                                 $path = public_path($review_img->image);
                                if (\File::exists($path)) {
                                    \File::delete($path);
                                }
                                if (!\File::exists($folder)) {
                                    mkdir($folder, 0755, true);
                                }
                                $image->save('uploads/users/' . $review->user_id . '/' . $name, 30);
                                $review_img->image = "uploads/users/$review->user_id/$name";
                            }

                            $review_img->review_id = $review->id;
                            $review_img->title = $img['title'];
                            $review_img->description = $img['description'];
                            $review_img->save();
                        }
                    }
                }
            }



            return response()->json([
                'success' => true,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
            ], 200);
        }
    }
    /**
     * Delete image
     */
    public function delete_image($id)
    {
        $review_image = ReviewImage::where('id', $id)->first();
        if (!empty($review_image)) {
            $path = public_path($review_image->image);
            if (\File::exists($path)) {
                \File::delete($path);
            }
            $review_image->delete();

            return response()->json([
                'success' => true,
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
}
