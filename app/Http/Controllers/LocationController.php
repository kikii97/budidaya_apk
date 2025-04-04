<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Location;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function showLocations()
    {
        // $locations = Location::all();
        // return view('locations', compact('locations'));

        $locations = DB::table('lokasi')->get();
        return view('map.location', ['locations' => $locations]);
    }
    //
}
