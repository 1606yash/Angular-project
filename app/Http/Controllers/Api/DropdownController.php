<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function index(){
    	$countries = Country::all()->pluck('name','id');
    	return json_encode($countries);
    }
    public function getStates($id){
    	$states= State::where('country_id',$id)->pluck('name','id');
        return json_encode($states);
    }
     public function getCities($id){
    	$cities= City::where('state_id',$id)->pluck('city','id');
        return json_encode($cities);
    }
}
