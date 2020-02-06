<?php

namespace App\Http\Controllers\Api\V1\Component;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Component;
use App\Models\Value;
use App\Models\Device;
use App\Models\Endpoint;
use App\Models\Activity;

class ValueController extends Controller
{
    public function store(Request $request)
    {
        $component_values = $request->json()->all();
        
        // validating header request
        if ($request->header('device-token') == "") {
            return response()->json(['message' => 'Header: device-token is required'], 400);
        }

        if (Device::find($request->header('device-token')) == null) {
            return response()->json([
                'message' => 'Incorrect device token'
            ], 400);
        }

        $device_serial_number = "";
        $alert_count = 0;

        foreach ($component_values as $component_value) {
            // get and update component data based on value's key
            $component = Component::where([
                'code' => $component_value['key'],
                'device_id' => $request->header('device-token')
            ])->first();

            // validating request
            if (!isset($component)) {
                return response()->json([
                    'message' => $component_value['key'].' is incorrect key'
                ], 200);
            }

            // check if numeric or not
            if ($component_value['value'] != null && !is_numeric($component_value['value'])) {
                return response()->json([
                    'message' => $component_value['key'].' value should be a numeric'
                ], 400);
            }

            // validating digital value request
            if ($component->type == "digital") {
                if ($component_value['value'] != 0 && $component_value['value'] != 1) {
                    return response()->json([
                        'message' => $component_value['key'].' value should be 0 or 1'
                    ], 200);
                }
            }

            $component->value = $component_value['value'];
            $component->save();

            // get device serial number
            $device_serial_number = $component->device->serial_number;
            
            // store to database
            $value = new Value;
            $value->component_id = $component->id;
            $value->value = (float) $component_value['value'];
            $value->date = date('Y-m-d');
            $value->save();

            // create new activity if an alert is found
            if ($component->type == "analog" && (!isset($component->value) || $component->value > $component->max_value || $component->value < $component->min_value)) {
                $activity = new Activity;
                $activity->icon = "icon-content-left";
                if (empty($component->value)){
                    $activity->title = "$component->name has null value";
                    $activity->color = "red";
                    $activity->type = "danger";
                    $activity->message = "An error was detected in the <b>$component->name</b> component of the <b>".$component->device->name."</b>";
                }
                elseif ($component->value > $component->max_value) {
                    $activity->title = "$component->name value exceeds the limit";
                    $activity->color = "orange";
                    $activity->type = "warning";
                    $activity->message = "Component <b>$component->name</b> on the <b>".$component->device->name."</b> has a value of <b>$component->value</b> that exceeds the maximum limit";
                }elseif($component->value < $component->min_value) {
                    $activity->title = "$component->name value is below the limit";
                    $activity->color = "orange";
                    $activity->type = "warning";
                    $activity->message = "Component <b>$component->name</b> on the <b>".$component->device->name."</b> has a value of <b>$component->value</b> that exceeds the maximum limit";
                }
                $activity->link = route('web.devices.component', $component->id);
                $activity->status = "new";
                $activity->save();

                // increament alert count
                $alert_count++;
            }elseif ($component->type == "digital" && !isset($component->value)) {
                $activity = new Activity;
                $activity->icon = "icon-content-left";
                $activity->title = "$component->name has null value";
                $activity->color = "red";
                $activity->type = "danger";
                $activity->status = "new";
                $activity->message = "An error was detected in the <b>$component->name</b> component of the <b>".$component->device->name."</b>";
                $activity->save();

                // increament alert count
                $alert_count++;
            }
        }
        
        // update data device
        $device = Device::where('serial_number', $device_serial_number)->first();
        $device->last_active_date = Carbon::now();
        $device->state = 1;
        if ($alert_count < count($component_values) && $alert_count != 0) {
            $device->alert = "warning";
        }elseif ($alert_count == count($component_values)) {
            $device->alert = "danger";
        }else {
            $device->alert = "normal";
        }
        $device->save();

        // update data received in endpoints table
        $endpoint = Endpoint::where('device_id', $device->id)->first();
        $endpoint->data_received = $endpoint->data_received + count($component_values);
        $endpoint->save();
        
        return response()->json(['message' => 'ok'], 200);
    }
}
