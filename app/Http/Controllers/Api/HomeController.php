<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceResource;
use App\Models\Affiliation;
use App\Models\AllHeader;
use App\Models\ChooseUs;
use App\Models\DummyReview;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceHeader;
use App\Models\Setting;
use App\Models\Topheader;
use Hamcrest\Core\AllOf;

class HomeController extends Controller
{
    /**
     *
     * fetch all services
     */
    public function Services()
    {
        $services =  Service::with('serviceImage')->inRandomOrder()->limit(4)->get();

        if (count($services) > 0) {
            return response()->json([
                'success' => true,
                'services' => ServiceResource::collection($services),
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
     * fetch all services
     */
    public function fetchData()
    {
        $topheader = Topheader::select('title', 'details', 'btn_text', 'btn_link', 'second_btn_text', 'second_btn_link', 'image')->first();
        $homeservietitle = ServiceHeader::select('home_title', 'home_details')->first();
        $choose_us = ChooseUs::select('title', 'image', 'details')->get();
        $choose_us_header = AllHeader::where('type', 'choose-us')->select('title', 'details')->first();
        $affiliation = Affiliation::select('id', 'link', 'image')->get();
        $affiliation_header = AllHeader::where('type', 'affiliation')->select('title', 'details')->first();
        $portfolio = Portfolio::select('id', 'title', 'image', 'details')->take(3)->get();
        $portfolio_header = AllHeader::where('type', 'portfolio')->select('title', 'details')->first();
        $review = DummyReview::select('id','user_name', 'image','location','text','rating')->get();
        $review_header = AllHeader::where('type', 'review')->select('title', 'details')->first();
        return response()->json([
            'success' => true,
            'topheader' => $topheader,
            'header_service' => $homeservietitle,
            'choose_us' => $choose_us,
            'choose_us_header' => $choose_us_header,
            'affiliation' => $affiliation,
            'affiliation_header' => $affiliation_header,
            'portfolio' => $portfolio,
            'portfolio_header' => $portfolio_header,
            'review' => $review,
            'review_header' => $review_header,
        ], 200);
    }
    /**
     *
     * fetch    FetchSetting
     */
    public function FetchSetting()
    {
        $service_pages = Page::where('type', 'service')->select('id', 'slug', 'title')->get();
        $company_pages = Page::where('type', 'company')->select('id', 'slug', 'title')->get();
        $setting = Setting::first();
        return response()->json([
            'success' => true,
            'setting' => $setting,
            'service_pages' => $service_pages,
            'company_pages' => $company_pages
        ], 200);
    }
}
