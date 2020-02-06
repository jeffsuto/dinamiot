<?php

namespace App\Http\Controllers\Web\Device;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Component;
use App\Models\Endpoint;
use App\Models\Activity;
use App\Models\Value;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['devices'] = Device::all();
        
        return view('pages.devices.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.devices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'serial_number' => 'required|unique:devices',
            'request_interval' => 'required|numeric'
        ]);
        
        // collect device identity's data to array
        $device = new Device;
        $device->name = $request->name;
        $device->serial_number = $request->serial_number;
        $device->description = $request->description;
        $device->state = 0;
        $device->alert = null;

        // check if has image
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time().'-'.str_replace(' ', '-', str_replace(' ', '_', $request->name)).'.'.$file->getClientOriginalExtension();
            $fullpath = public_path().'/assets/images/devices';

            // check if directory is doesn't exists
            \File::isDirectory($fullpath) or \File::makeDirectory($fullpath, 0777, true, true);
            
            $device->image_fullpath = $fullpath."/$filename";
            $device->image_url = asset("/assets/images/devices/$filename");

            $file->move($fullpath, $filename);
        }

        // store to database
        $device->save();
        
        // collect components to array
        for ($i=0; $i < count($request->component_name); $i++) {
            $component = new Component;
            $component->device_id = $device->id;
            $component->name = $request->component_name[$i];
            $component->code = $this->generateComponentCode($request->component_name[$i]);
            $component->value = null;
            $component->type = $request->component_type[$i];

            if ($request->component_type[$i] == 'analog') {
                $component->unit = $request->component_unit[$i];
                $component->min_value = $request->component_min_value[$i];
                $component->max_value = $request->component_max_value[$i];
            }

            // store to database
            $component->save();
        }

        // make format data example for endpoint parameter
        foreach ($device->components as $component) {
            $data[] = [
                'key' => $component->code,
                'value' => ($component->type == 'digital' ? "The digital type value should be 0 or 1":"Your analog value")
            ];
        }

        // create endpoint
        $endpoint = new Endpoint;
        $endpoint->device_id = $device->id;
        $endpoint->url = route('api.v1.components.value.store');
        $endpoint->data_example = json_encode($data);
        $endpoint->headers = [
            [
                'key' => 'Content-Type',
                'value' => 'application/json'
            ],
            [
                'key' => 'device-token',
                'value' => $device->id
            ]
        ];
        $endpoint->method = 'POST';
        $endpoint->data_received = 0;
        $endpoint->request_interval = $request->request_interval;
        $endpoint->save();

        // create activity
        $activity = new Activity;
        $activity->type = "success";
        $activity->title = "New device has been added";
        $activity->color = "teal";
        $activity->icon = "icon-drive";
        $activity->status = "new";
        $activity->message = "You have successfully created new device: <b>$device->name</b> with serial number:<b>$device->serial_number</b> and has ".
                             count($request->component_name)." component".
                             (count($request->component_name)==1 ?:"s");
        $activity->link = route('web.devices.show', $device->id);
        $activity->save();

        return redirect()->route('web.devices.show', $device->id)->with(['success' => 'Successfully created new device']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        $data['device'] = $device;

        return view('pages.devices.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        $data['device'] = $device;

        return view('pages.devices.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {   
        $validatedData = $request->validate([
            'name' => 'required',
            'serial_number' => 'required|unique:devices,serial_number,'.$device->id.',_id',
            'request_interval' => 'required|numeric'
        ]);
        
        // collect device identity's data to array
        $device->name = $request->name;
        $device->serial_number = $request->serial_number;
        $device->description = $request->description;

        // check if has image
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time().'-'.str_replace(' ', '-', str_replace(' ', '_', $request->name)).'.'.$file->getClientOriginalExtension();
            $fullpath = public_path().'/assets/images/devices';
            
            // delete old image
            if (\File::exists($device->image_fullpath)) {
                \File::delete($device->image_fullpath);
            }

            // check if directory is doesn't exists
            \File::isDirectory($fullpath) or \File::makeDirectory($fullpath, 0777, true, true);

            $device->image_fullpath = $fullpath."/$filename";
            $device->image_url = asset("/assets/images/devices/$filename");

            $file->move($fullpath, $filename);
        }

        // store to database
        $device->save();
        
        // delete components and its values
        $deleted_components = $device->components()->whereNotIn(
            '_id', $request->component_id
        );
        $deleted_values = Value::whereIn('component_id', $deleted_components->pluck('id'));
        
        $minus_data_received = $deleted_values->get()->count();

        $deleted_values->delete();
        $deleted_components->delete();

        // update existing component data
        for ($i=0; $i < count($request->component_id); $i++) {

            $component = Component::find($request->component_id[$i]);
            $component->name = $request->component_name[$i];
            $component->type = $request->component_type[$i];

            if ($component->type == "analog") {    
                $component->unit = $request->component_unit[$i];
                $component->min_value = $request->component_min_value[$i];
                $component->max_value = $request->component_max_value[$i];
            }

            // get name from component code
            $name_from_code = explode('_', $component->code)[1];
            $first_name = strtolower(explode(' ', $component->name)[0]);
            if ($name_from_code != $first_name) {
                $component->code = $this->generateComponentCode($request->component_name[$i]);
            }

            // update database
            $component->save();
        }

        // add new component
        for ($i=count($request->component_id); $i < count($request->component_name); $i++) {
            $component = new Component;
            $component->device_id = $device->id;
            $component->name = $request->component_name[$i];
            $component->code = $this->generateComponentCode($request->component_name[$i]);
            $component->value = null;
            $component->type = $request->component_type[$i];

            if ($request->component_type[$i] == 'analog') {
                $component->unit = $request->component_unit[$i];
                $component->min_value = $request->component_min_value[$i];
                $component->max_value = $request->component_max_value[$i];
            }

            // store to database
            $component->save();
        }

        // make format data example for endpoint parameter
        foreach ($device->components as $component) {
            $data[] = [
                'key' => $component->code,
                'value' => ($component->type == 'digital' ? "The digital type value should be 0 or 1":"Your analog value")
            ];
        }

        // create endpoint
        $endpoint = Endpoint::where('device_id', $device->id)->first();
        $endpoint->data_example = json_encode($data);
        $endpoint->data_received = $endpoint->data_received - $minus_data_received;
        $endpoint->request_interval = $request->request_interval;
        $endpoint->save();

        // create activity for updated device
        $activity = new Activity;
        $activity->type = "success";
        $activity->title = "Device:$device->name has been updated";
        $activity->color = "teal";
        $activity->icon = "icon-drive";
        $activity->message = "You have successfully updated Device: <b>$device->name</b> with serial number:<b>$device->serial_number</b> and has ".
                             count($request->component_name)." component".
                             (count($request->component_name) == 1 ?: "s");
        $activity->link = route('web.devices.show', $device->id);
        $activity->status = "new";
        $activity->save();

        // create activity for updated endpoint
        $activity = new Activity;
        $activity->type = "info";
        $activity->title = "Device:$device->name's endpoint has been updated";
        $activity->color = "blue";
        $activity->icon = "icon-sphere";
        $activity->message = "Device: <b>$device->name's endpoint</b> with serial number:<b>$device->serial_number</b> has been updated. Please check your device endpoint now!";
        $activity->link = route('web.endpoints.show', $device->endpoint->id);
        $activity->status = "new";
        $activity->save();

        return redirect()->route('web.devices.show', $device->id)->with([
            'success' => "You have successfully updated this device.".
                         "The endpoints of this device may have changes.".
                         " <a href='".route('web.endpoints.show', $endpoint->id)."'>Check this device's endpoint now</a>"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        // delete image
        if (\File::exists($device->image_fullpath)) {
            \File::delete($device->image_fullpath);
        }

        Value::where('component_id', [Component::where('device_id', $device->id)->pluck('_id')]);
        Component::where('device_id', $device->id)->delete();
        Endpoint::where('device_id', $device->id)->delete();

        // create activity for updated endpoint
        $activity = new Activity;
        $activity->type = "danger";
        $activity->title = "Device:$device->name has been deleted";
        $activity->color = "red";
        $activity->icon = "icon-drive";
        $activity->message = "Device: <b>$device->name's endpoint</b> with serial number:<b>$device->serial_number</b> and its data has been deleted.";
        $activity->link = "javascript:void(0);";
        $activity->status = "new";
        $activity->save();

        $device->delete();

        return response()->json(['message' => 'success'], 200);
        // return redirect()->route('web.devices.index')->with(['success', 'Successfully deleted device']);
    }

    private function generateComponentCode($name){
        // get last component's code number
        $last_component = Component::orderBy('_id', 'desc')->first();

        if (empty($last_component)) {
            $current_code = 'c1_'.str_replace(' ', '_', strtolower($name));
        }else {
            $splited = explode("_", $last_component->code);
            $sequence_to = substr($splited[0], 1);
            $current_code = 'c'.($sequence_to + 1).'_'.str_replace(' ', '_', strtolower($name));
        }

        return $current_code;
    }
}
