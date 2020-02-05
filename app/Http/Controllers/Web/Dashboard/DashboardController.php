<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;

use App\Models\Device;
use App\Models\Value;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['devices'] = Device::all();

        if ($request->ajax()) {
            return view('partials.ajax.devices-on-dashboard', $data)->render();
        }
        
        return view('pages.dashboard.index', $data);
    }
}
