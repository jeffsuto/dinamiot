<?php
/**
 * Route for breadcrumbs
 */

//  Dashboard
Breadcrumbs::for('dashboard', function($trail){
    $trail->push('Dashboard', route("web.dashboard.index"));
});
// -----------------------------------------------------------------------------
/**
 * Device's breadcrumbs
 */
// Devices
Breadcrumbs::for('devices', function($trail){
    $trail->parent('dashboard');
    $trail->push('Devices', route('web.devices.index'));
});

// Device > Create
Breadcrumbs::for('devices.create', function($trail){
    $trail->parent('devices');
    $trail->push('Create New Device', route('web.devices.create'));
});

// Device > Show
Breadcrumbs::for('devices.show', function($trail, $device){
    $trail->parent('devices');
    $trail->push($device->name, route('web.devices.show', $device->id));
});

// Device > [Component]
Breadcrumbs::for('devices.show.component', function($trail, $component){
    $trail->parent('devices.show', $component->device);
    $trail->push($component->name);
});
// -----------------------------------------------------------------------------
/**
 * Endpoint's breadcrumbs
 */
// Endpoints
Breadcrumbs::for('endpoints', function($trail){
    $trail->parent('dashboard');
    $trail->push('Endpoints', route('web.endpoints.index'));
});

// Device > Show
Breadcrumbs::for('endpoints.show', function($trail, $endpoint){
    $trail->parent('endpoints');
    $trail->push($endpoint->device->name, route('web.endpoints.show', $endpoint->id));
});
// -----------------------------------------------------------------------------
/**
 * Activity's breadcrumbs
 */
// Activities
Breadcrumbs::for('activities', function($trail){
    $trail->parent('dashboard');
    $trail->push('Activities', route('web.activities.index'));
});