<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MetaInfo;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Meta($type)
    {

        $meta =  MetaInfo::where('type', $type)->first();
        if (!empty($meta)) {
            return response()->json([
                'success' => true,
                'type' => $type,
                'meta' => $meta,
            ], 200);
        }

        return response()->json([
            'success' => false,
        ], 200);
    }
}