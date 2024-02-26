<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPageBySlug($slug)
    {

        $page =  Page::where('slug', $slug)->first();
        if (!empty($page)) {
            return response()->json([
                'success' => true,
                'page' => $page,
            ], 200);
        }

        return response()->json([
            'errors' => [
                "message" => 'Page Not found!'
            ],
        ], 404);
    }
}