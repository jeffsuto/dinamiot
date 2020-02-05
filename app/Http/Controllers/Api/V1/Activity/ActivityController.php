<?php

namespace App\Http\Controllers\Api\V1\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Activity;

class ActivityController extends Controller
{
    public function count()
    {
        $activities_count = Activity::where('status', 'new')->orderBy('created_at', 'desc')->get()->count();

        return response()->json($activities_count, 200);
    }

    public function new()
    {
        $data['activities'] = Activity::where('status', 'new')->orderBy('created_at', 'desc')->get();

        return view('partials.ajax.notification-list', $data)->render();
    }

    public function read(Request $request)
    {
        if ($request->filled('action')) {
            if ($request->action == "read all") {
                Activity::where('status', 'new')->update(['status' => 'read']);
            }
        }elseif ($request->filled('id')) {
            Activity::find($request->id)->update(['status' => 'read']);
        }

        return response()->json(['message' => 'success'], 200);
    }
}
