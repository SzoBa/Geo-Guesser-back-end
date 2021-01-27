<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Map::all(), 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->get('id');
        if (is_null($id)){
            return response(['message'=> 'No id!'], 404);
        }
        $map = Map::find($id);
        if (is_null($map)) {
            return response(['message'=> 'Invalid map id!'], 404);
        }

        $cities = DB::table('maps')->join('map-city', 'maps.id', '=', 'map_id')
            ->join('cities', 'city_id', '=', 'cities.id')
            ->select('maps.*', 'cities.*')
            ->where('maps.id', '=', $id)
            ->get();

        return response($cities, 200);
    }
}
