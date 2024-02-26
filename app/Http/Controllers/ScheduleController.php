<?php

namespace App\Http\Controllers;

use App\Models\OrderDate;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class ScheduleController extends Controller
{
    function __construct(Request $request)
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('pages.schedule.schedule');
    }
    public function store(Request $request)
    {
        $date  = Carbon::now()->subDays(35);
        Schedule::where('created_at', '<', $date)->delete();
        $datetime = collect($request->datetime);
        foreach ($datetime as $dt) {
            if ($dt['is_book'] === true) {
                Schedule::where('date',  $dt['date'])->where('time', $dt['time'])->delete();
            } else {
                $d = new Schedule();
                $d->date = $dt['date'];
                $d->time = $dt['time'];
                $d->save();
            }
        }
        return response()->json([
            'success' => true,
        ], 200);
    }

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
}