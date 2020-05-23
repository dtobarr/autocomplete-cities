<?php

namespace App\Http\Controllers\Utils;

use App\City;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CityResource;

class CityFilter
{
    public function filter($request)
    {
        try {

            // get lat/lng
            $lat = $request->input('latitude');
            $lng = $request->input('longitude');

            // start with filter
            $cities = City::where('name', 'LIKE', "%{$request->input('q')}%");

            if($lat && $lng){
                // Use haversine formula
                $cities = $cities->select('*', DB::raw('(3959 * acos( cos( radians('. $lat .') ) 
                            * cos( radians( latitude ) ) * cos( radians( longitude ) 
                            - radians('. $lng .')) + sin( radians('. $lat .') ) 
                            * sin( radians( latitude ) ) ) ) AS distance'))
                            ->orderByRaw('distance')
                            ->limit(6)->get();

                $result = $this->distanceScore($cities, $request->input('q'), $lat);
                return CityResource::collection($result);
            }

            $cities = $cities->limit(6)->get();
            $result = $this->distanceScore($cities, $request->input('q'));
            return CityResource::collection($result);
            
        } catch (Exception $exception) {
            return response()->json(['error' => 'Invalid filter.'], 422);
        }
    }

    public function distanceScore($results, $query, $dist = null)
    {
        $size = $results->count();
        
        // text match
        if($size > 0){
            $results->each(function ($result) use ($query) {
                similar_text($query, $result['name'], $percent);
                $result['score'] = round($percent/100, 1);
            });
        }
       
        // text and lat/lng match
        if($dist){
            $low = 0;
            if($size > 0){
                $high = $results[$size - 1]->distance + 1;
                $results->each(function ($result) use ($high, $low) {
                    $dis_score = round(($high - $result['distance']) / ($high - $low), 1);
                    // get average
                    $result['score'] = round(($dis_score + $result['score']) / 2, 1);
                });
            }
        }
        
        return $results->sortByDesc('score');
    }
}