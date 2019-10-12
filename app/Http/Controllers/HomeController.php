<?php

namespace App\Http\Controllers;

use App\field;
use App\Fixture;
use App\property;
use App\PropertyAppliance;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        //$fixtures = Fixture::with('homeTeam', 'visitorTeam')->get()->sortBy('week')->first();
        //dd($fixtures->homeTeam);

        $teams = Team::all()->sortBy('points');

        $fixtures = Fixture::all()->sortBy('week');

        $unplayedWeek = Fixture::where("played", false)->orderBy('week','asc')->get()->first();

        if(null !== $unplayedWeek){
            $thisWeekMatches = Fixture::with('homeTeam','visitorTeam')->where('week', $unplayedWeek->week)->get();
        }else{
            $thisWeekMatches = array();
        }

        return view('home', [
            'teams'             => $teams,
            'fixtures'          => $fixtures,
            'week'              => (null!== $unplayedWeek) ? $unplayedWeek->week : 0,
            'thisWeekMatches'   => $thisWeekMatches
        ]);
    }
}
