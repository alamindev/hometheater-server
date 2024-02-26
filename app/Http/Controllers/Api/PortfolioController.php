<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AllHeader;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     *
     * fetch all services
     */
    public function fetchData()
    {
        $portfolio = Portfolio::select('id','title', 'image','details')->get();
        $portfolio_header = AllHeader::where('type','portfolio')->select('title', 'details')->first();
          return response()->json([
            'success' => true,
            'portfolio' => $portfolio,
            'portfolio_header' => $portfolio_header,
        ], 200);
    }
    /**
     *
     * fetch all services
     */
    public function portfolioDetails($id)
    {
        $portfolio = Portfolio::where('id',$id)->select('id','title', 'image','details')->first();
            return response()->json([
            'success' => true,
            'portfolio' => $portfolio,
        ], 200);
    }
}