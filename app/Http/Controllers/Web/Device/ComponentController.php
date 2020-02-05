<?php

namespace App\Http\Controllers\Web\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Component;

class ComponentController extends Controller
{
    public function show(Request $request, $id)
    {
        $component = Component::findOrFail($id);
        $component_values = "";

        // Filtering by date
        if ($request->filled('f')) {
            switch ($request->f) {
                case 'today':
                    $component_values = $component->values()->where('date', Carbon::now()->format('Y-m-d'))
                                                ->orderBy('created_at', 'desc')->get();
                    $data['time'] = 'Today - '.Carbon::now()->format('d F Y');
                    break;
                case 'yesterday':
                    $component_values = $component->values()->where('date', '=', Carbon::yesterday()->format('Y-m-d'))
                                                ->orderBy('created_at', 'desc')->get();
                    $data['time'] = 'Yesterday - '.Carbon::yesterday()->format('d F Y');
                    break;
                case 'last week':
                    $component_values = $component->values()->whereBetween('date', [Carbon::now()->subDays(7)->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
                                                ->orderBy('created_at', 'desc')->get();
                    $data['time'] = 'This week | '.Carbon::now()->subDays(7)->format('d F Y').' - '.Carbon::now()->format('d F Y');
                    break;
                case 'last month':
                    $component_values = $component->values()->whereBetween('date', [Carbon::now()->subMonths()->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
                                                ->orderBy('created_at', 'desc')->get();
                    $data['time'] = 'This month | '.Carbon::now()->subMonths()->format('d F Y').' - '.Carbon::now()->format('d F Y');
                    break;
                case 'last year':
                    $component_values = $component->values()->whereBetween('date', [Carbon::now()->subYears()->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
                                                ->orderBy('created_at', 'desc')->get();
                    $data['time'] = 'This year | '.Carbon::now()->subYears()->format('d F Y').' - '.Carbon::now()->format('d F Y');
                    break;
                default:
                    $component_values = $component->values()->orderBy('created_at', 'desc')->get();
                    $data['time'] = 'All time';
                    break;
            }
        }elseif ($request->filled('start_date')) {
            if ($request->filled('end_date')) {
                $component_values = $component->values()->whereBetween('date', [$request->start_date, $request->end_date])
                                                ->orderBy('created_at', 'desc')->get();
                $data['time'] = date('d F Y', strtotime($request->start_date)).' - '.date('d F Y', strtotime($request->end_date));
            }else {
                $component_values = $component->values()->where('date', $request->start_date)
                                                ->orderBy('created_at', 'desc')->get();
                $data['time'] = date('d F Y', strtotime($request->start_date));
            }
        }else {
            $component_values = $component->values()->orderBy('created_at', 'desc')->get();
            $data['time'] = 'All time';
        }
        
        // response for ajax request
        $no = 1;
        if ($request->ajax()) {
            $data = array();
            if ($request->has('summary')) {
                $data['max'] = number_format($component_values->max('value'), 1);
                $data['min'] = number_format($component_values->where('value', '<>', '')->min('value'), 1);
                $data['avg'] = number_format($component_values->avg('value'), 1);
                $data['data_received'] = $component_values->count();
            }else {
                foreach ($component_values as $component_value) {
                    $state = "";
                    if (empty($component_value->value)) {
                        $state = '<span class="tag tag-pill tag-default">Error</span>';
                    }elseif ($component_value->value > $component->max_value) {
                        $state = '<span class="tag tag-pill tag-danger">exceeding</span>';
                    }elseif ($component_value->value == $component->max_value) {
                        $state = '<span class="tag tag-pill tag-warning">maximum</span>';
                    }elseif ($component_value->value == $component->min_value) {
                        $state = '<span class="tag tag-pill tag-warning">minimum</span>';
                    }elseif ($component_value->value < $component->min_value) {
                        $state = '<span class="tag tag-pill tag-orange">low</span>';
                    }else {
                        $state = '<span class="tag tag-pill tag-success">normal</span>';
                    }
    
                    $data['data'][] = [
                        $no,
                        $component_value->created_at->format('M d, Y'),
                        $component_value->created_at->format('H:i:s'),
                        "<b>".number_format($component_value->value, 2)." </b><small class='text-muted'>$component->unit</small>",
                        $state,
                    ];
    
                    $no++;
                }
            }

            return $data;
        }

        $data['component'] = $component;
        $data['component_values'] = $component_values;

        return view('pages.devices.component', $data);
    }
}
