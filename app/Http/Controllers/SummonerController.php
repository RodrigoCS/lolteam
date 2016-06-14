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
    private $apiKey;
    private $region;

    public function __construct()
    {
        $this->apiKey = $_ENV['RIOT_API_KEY']; 
        $this->region = Auth::user()->region;
    }


    public function getSummoner() {

    }

    public function getLeagueEntry($summonerId) {
        $url = 'https://'.$this->region.'.api.pvp.net/api/lol/'.$this->region.'/v2.5/league/by-summoner/'.$summonerId.'/entry?api_key='.$this->apiKey;
        $response = file_get_contents($url);
        $leagueEntry =  json_decode($response);
        return $leagueEntry->{$summonerId}[0];
    }

    public function summoner(Request $request) {

        $summonerName = Auth::user()->summoner;
        $url = 'https://'.$this->region.'.api.pvp.net/api/lol/'.$this->region.'/v1.4/summoner/by-name/'.$summonerName.'?api_key='.$this->apiKey;

        $response = file_get_contents($url);
        $summoner =  json_decode($response);
        //$summonerName = summoner_info_array_name($summonerName);

        $name = $summoner->{$summonerName}->{'name'};
        $level= $summoner->{$summonerName}->{'summonerLevel'};
        $leagueEntry = $this->getLeagueEntry($summoner->{$summonerName}->{'id'});


        //dd($leagueEntry->{'entries'}[0]->{'division'});
        return view('summoner/summoner', ['summoner' => $summoner->{$summonerName}, 'leagueEntry' => $leagueEntry]);

        //return redirect()->route('summoner/search/{region}/{summonerName}', ['location' => $location, 'search' => $search]);
    }
}
