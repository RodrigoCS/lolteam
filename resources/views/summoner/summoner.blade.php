@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Summoner: {{Auth::user()->summoner}}</div>

                <div class="panel-body">
                    You are logged in!
                    <hr>
                    {{$name}} -- {{$level}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
