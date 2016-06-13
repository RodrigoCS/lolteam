<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;


function summoner_info_array_name($summoner) {
	$summoner_lower = mb_strtolower($summoner, 'UTF-8');
	$summoner_nospaces = str_replace(' ', '', $summoner_lower);
	return $summoner_nospaces;
}



class SummonerController extends Controller
{
    public function summoner(Request $request) {
        
            $summonerName = Auth::user()->summoner;
            $region = Auth::user()->region;
            $APIKey = "844dbefd-2dcc-420c-9f3a-4095fde86813";
            $url = "https://lan.api.pvp.net/api/lol/lan/v1.4/summoner/by-name/$summonerName?api_key=844dbefd-2dcc-420c-9f3a-4095fde86813";
            $url2 = "https://lan.api.pvp.net/api/lol/".$region."/v1.4/summoner/by-name/".$summonerName."?api_key=".$APIKey; 
            $response = file_get_contents($url);
            $summoner =  json_decode($response);

            $summonerName = summoner_info_array_name($summonerName);

            $name = $summoner->{$summonerName}->{'name'};
            $level= $summoner->{$summonerName}->{'summonerLevel'};
            return view('summoner/summoner', ['name' => $name, 'level' => $level]);

        //return redirect()->route('summoner/search/{region}/{summonerName}', ['location' => $location, 'search' => $search]);
    }
}
