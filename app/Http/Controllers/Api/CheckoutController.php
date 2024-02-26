<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceQuestionMainResource;
use App\Http\Resources\ServiceQuestionResource;
use App\Models\Order;
use App\Models\OrderDate;
use App\Models\Promo;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ServiceQuestion;
use App\Models\User;
use App\Models\Zipcode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Checkout;

class CheckoutController extends Controller
{
    public function __construct(){
        //Make sure you don't store your API Key in your source code!

    }
    /**
     *
     * check promocode
     */
    public function MatchPromo(Request $request)
    {
        $promo =  Promo::where('code', $request->promocode)->first();
        if (!empty($promo)) {
            if ($promo->end_date->isFuture()) {
                return response()->json([
                    'success' => true,
                    'percent' =>  $promo->percent,
                ], 200);
            } else {
                return response()->json([
                    'errors' => [
                        "message" => 'Sorry! That discount code has expired.'
                    ],
                ], 404);
            }
        } else {
            return response()->json([
                'errors' => [
                    "message" => 'Sorry! Invalid promo code'
                ],
            ], 404);
        }
    }
    /**
     *
     * check promocode
     */
    public function CheckZipcode(Request $request)
    {
        $rules = array(
            'zipcode' => 'required|regex:/\b\d{5}\b/',
        );
        $validator = Validator::make($request->all(), (array)$rules);

        if (!$validator->fails()) {
            $zip =  Zipcode::where('zipcode', $request->zipcode)
                ->where('amount', '<=', $request->amount)
                ->first();
            if (!empty($zip)) {
                return response()->json([
                    'success' => true,
                    'message' =>  'We offer service in your location. Click next to continue',
                ], 200);
            }
            return response()->json([
                'errors' => [
                    "ziperror" => 'Sorry! We do not offer service in your location'
                ],
            ], 404);
        }
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }
    /**
     *
     *  get service question
     */
    public function ServiceQuestions(Request $request)
    {

        $carts = $request->carts;
        if (count($carts) > 0) {

            $cartDatas = [];

            foreach ($carts as $key => $cart) {
                $item = $cart['item'];
                $questions = [];
                $service = Service::where('id', $cart['id'])->first();
                for ($i = 0; $i < $item; $i++) {
                    $serQuestion = ServiceQuestion::with('question_option')->where('service_id', $cart['id'])->get();
                    if (count($serQuestion) > 0) {
                        $j = $i + 1;
                        $count = '';
                        if ($item != 1) {
                            $count = "<br> Question <span>#$j</span>";
                        }

                        $questions[$i]['title'] = $service->title . $count;
                        $questions[$i]['service_id'] =  $service->id;
                        $questions[$i]['questions'] =  $serQuestion;
                    }
                }
                $cartDatas[$key] = $questions;
            }
            $datas =   array_reduce($cartDatas, 'array_merge', array());
            return response()->json([
                'success' => true,
                'questions' => ServiceQuestionMainResource::collection($datas),
            ], 200);
        }
        return response()->json([
            'success' => 'false'
        ], 200);
    }
    /**
     *
     *  check booking date
     */
    public function CalendarAttr()
    {
        $dates = OrderDate::whereHas('order', function (Builder $query) {
            return $query->where('status', 'pending')->orWhere('status', 'approved');
        })
            ->havingRaw('COUNT(date) >= 8')
            ->select('date')
            ->whereDate('date', '>=', Carbon::now())
            ->groupBy('date')
            ->get();

        $datestwo = Schedule::havingRaw('COUNT(date) >= 8')
            ->select('date')
            ->groupBy('date')
            ->whereDate('date', '>=', Carbon::now())
            ->get();
        $mergedArray = array_merge($dates->toArray(), $datestwo->toArray());
        if (count($mergedArray) > 0) {
            return response()->json([
                'success' => true,
                'dates' =>  $mergedArray,
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
    /**
     *
     *  check booking date
     */
    public function CalendarTime(Request $request)
    {
        if ($request->date) {
            $times = OrderDate::whereHas('order', function (Builder $query) {
                return $query->where('status', 'pending')->orWhere('status', 'approved');
            })
                ->whereDate('date', '=', $request->date)
                ->select('id', 'time', 'order_id')->get();

            $timestwo = Schedule::whereDate('date', '=', $request->date)
                ->select('id', 'time')->get();
            $mergedArray = array_merge($times->toArray(), $timestwo->toArray());
            if (count($mergedArray) > 0) {
                return response()->json([
                    'success' => true,
                    'times' =>  $mergedArray,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                ], 200);
            }
        }
    }
    public function createCharge(Request $request)
    {
        ApiClient::init('14d206be-2d13-4ead-9cdc-d002d2fdd43b');

        $chargeData = [
            'name' => $request->name,
            'description' => $request->description,
            'local_price' => [
                'amount' => $request->amount,
                'currency' => 'USD'
            ],
            'pricing_type' => 'fixed_price',
            'requested_info' => ['name', 'email']
        ];
        $chargeObj = Checkout::create($chargeData);
      return  $chargeObj->id;
    }

}
