<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    public function autocomplete(Request $request)
    {
        $phrase = $request->phrase;
        $data = City::select('name', 'geonameid', 'latitude', 'longitude')->where('name','LIKE','%'.$phrase.'%')->take(10)->get();

        if ($data) {
            return response($data, 200);
        } else {
            return response([
                "status" => "error",
                "message" => "failed on searching data"
            ], 401);
        }

    }

    public function getNearestCities(Request $request)
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $distance_query = sprintf("( 3956 * 2 * ASIN(SQRT( POWER(SIN(( %s - latitude) * pi()/180 / 2), 2) +
            COS(%s * pi()/180) * COS(latitude * pi()/180) *
            POWER(SIN(( %s - longitude) * pi()/180 / 2), 2) )) ) AS distance", $lat, $lat, $lng);

        $query =  DB::select("SELECT *,$distance_query from cities order by distance LIMIT 21");

        return response()->json($query);
    }
}
