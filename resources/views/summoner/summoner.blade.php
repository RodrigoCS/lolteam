@extends('layouts.new')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Summoner: {{ $summoner->id }}</div>

                <div class="panel-body">

                    <div class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-thumbnail" src="{{ asset('/lolteam/assets/images/profileIcons/profileIcon'.$summoner->profileIconId.'.jpg') }}" alt="{{ $summoner->name }}">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">{{ $summoner->name }} <span class="summoner_tag">{{Auth::user()->club_tag}}</span></h4>
                        <span>Level: </span>{{ $summoner->summonerLevel }}
                        <div>{{ $leagueEntry->queue }}</div>
                        {{ $leagueEntry->name }}
                        <div>
                            {{ $leagueEntry->tier }}
                            {{ $leagueEntry->entries[0]->{'division'} }} >
                            {{ $leagueEntry->entries[0]->{'leaguePoints'} }} LP
                        </div>
                        <span class="text-success">{{ $leagueEntry->entries[0]->{'wins'} }}</span>
                        /<span class="text-danger">{{ $leagueEntry->entries[0]->{'losses'} }}</span>
                        > {{ round(100/((($leagueEntry->entries[0]->{'wins'})+($leagueEntry->entries[0]->{'losses'}))/($leagueEntry->entries[0]->{'wins'})), 2) }} %

                      </div>
                    </div>

                </div>
            </div>
        </div>

        <!--MATCHES-->
        <section id="matches">
            @foreach($matches as $match)
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $match->queue }}</div>

                        <div class="panel-body">

                            <div class="media">
                              <div class="media-left">
                                <a href="#">
                                  <img width="60px" class="media-object img-thumbnail" src="{{ asset('/lolteam/assets/images/champions/'.str_replace("'", "", $match->champion).'.png') }}" alt="{{ $match->champion }}">
                                </a>
                              </div>
                              <div class="media-body">
                                <h4 class="media-heading">{{ $summoner->name }} <span class="summoner_tag">{{Auth::user()->club_tag}}</span></h4>
                                {{ $match->lane }}
                                <div>
                                    {{ $match->champion }}
                                </div>
                              </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </div>

       
</div>
@endsection
