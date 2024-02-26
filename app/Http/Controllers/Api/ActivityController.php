<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * fetch all activities
     */
    public function Activities()
    {
        $activities = Activity::with('user')->latest()->limit(10)->get();
        return response()->json([
            'success' => true,
            'activities' => ActivityResource::Collection($activities),
        ], 200);
    }
    /**
     * fetch all activities by user id
     */
    public function userActivities($id)
    {
        $user_activities = Activity::with('user')->where('user_id', $id)->latest()->limit(10)->get();
        return response()->json([
            'success' => true,
            'user_activities' =>  ActivityResource::Collection($user_activities),
        ], 200);
    }
}