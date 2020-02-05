<?php

namespace App\Http\Controllers\Api\V1\Dataset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Value;

class LiveChartController extends Controller
{
    public function index(Request $request)
    {
        $component_values = Value::where('component_id', $request->id)->get();
        $data = array();
        foreach ($component_values as $component_value) {
            $data[] = [
                'date' => strtotime($component_value->created_at)*1000,
                'value' => $component_value->value
            ];
        }

        return response()->json($data, 200);
    }
}
