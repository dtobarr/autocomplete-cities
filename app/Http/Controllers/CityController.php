<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\Utils\CityFilter;

class CityController extends Controller
{
    /**
     * Display a listing of the cities.
     *
     * @param  App\Http\Requests\CityRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggestions(CityRequest $request)
    {
        $cityFilter = new CityFilter();
        return $cityFilter->filter($request);
    }
}