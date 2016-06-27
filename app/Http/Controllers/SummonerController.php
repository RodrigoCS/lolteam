<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
Use App\Champion;


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


    public function getSummonerByName($summonerName) {
        $url = 'https://'.$this->region.'.api.pvp.net/api/lol/'.$this->region.'/v1.4/summoner/by-name/'.$summonerName.'?api_key='.$this->apiKey;
        $response = file_get_contents($url);
        $summoner =  json_decode($response);
        return $summoner->{$summonerName};
    }

    public function getLeagueEntry($summonerId) {
        $url = 'https://'.$this->region.'.api.pvp.net/api/lol/'.$this->region.'/v2.5/league/by-summoner/'.$summonerId.'/entry?api_key='.$this->apiKey;
        $response = file_get_contents($url);
        $leagueEntry =  json_decode($response);
        return $leagueEntry->{$summonerId}[0];
    }

    public function getMatchList($summonerId, $numberOfMatches){
        $url = 'https://'.$this->region.'.api.pvp.net/api/lol/'.$this->region.'/v2.2/matchlist/by-summoner/'.$summonerId.'/?beginIndex=0&endIndex='.$numberOfMatches.'&api_key='.$this->apiKey;
        $response = file_get_contents($url);
        $matchList =  json_decode($response);
        return $matchList;
    }

    public function getChampionName($championId) {
        $champion = Champion::find($championId);
        return $champion->name;
    }

    public function mySummoner(Request $request) {
        $summonerName = Auth::user()->summoner;
        $summoner = $this->getSummonerByName($summonerName);
        $leagueEntry = $this->getLeagueEntry($summoner->{'id'});
        $matches = $this->getMatchlist($summoner->{'id'}, 6)->matches;
        foreach ($matches as $match) {
            $match->champion = $this->getChampionName($match->champion);
            $match->info = $this->getMatch($match->matchId);
            //dd($match);
            //dd($this->getMatch($match->matchId)); 
        }
        return view('summoner/summoner', ['summoner' => $summoner, 'leagueEntry' => $leagueEntry, 'matches' => $matches]);
    }


    public function getMatch($matchId){
        $url = 'https://'.$this->region.'.api.pvp.net/api/lol/'.$this->region.'/v2.2/match/'.$matchId.'?api_key='.$this->apiKey;
        $response = file_get_contents($url);
        $match =  json_decode($response);
        return $match;
    }


}
