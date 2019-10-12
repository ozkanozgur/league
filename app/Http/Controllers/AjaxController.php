<?php

namespace App\Http\Controllers;

use App\field;
use App\Fixture;
use App\property;
use App\PropertyAppliance;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{

    private function diceIt(){
        return array(
            'home'      => mt_rand(1,100),
            'visitor'   => mt_rand(1,100)
        );
    }

    private function getCalc($teamId, $propertyId){
        return PropertyAppliance::where('team_id', $teamId)
            ->where('property_id', $propertyId)
            ->get()
            ->first()
            ->property_total;
    }

    public function loadFixtures(){
        $fixtures = Fixture::with('homeTeam', 'visitorTeam')->get()->sortBy('week');
        return response()->json($fixtures);
    }

    public function loadLeagueTable(){
        $teams = Team::all()->sortByDesc('points');

        $results = array();

        $teams->each(function ($team) use (&$results){
            $allGoals = Fixture::select(DB::raw('SUM(home_goals) as goalsfor, SUM(visitor_goals) as goalsagainst'))
                ->where('home', $team->id)
                ->get()->first();
            $goalsFor = $allGoals->goalsfor;
            $goalsAgainst = $allGoals->goalsagainst;

            $allGoals = Fixture::select(DB::raw('SUM(home_goals) as goalsagainst, SUM(visitor_goals) as goalsfor'))
                ->where('visitor', $team->id)
                ->get()->first();
            $goalsFor += $allGoals->goalsfor;
            $goalsAgainst += $allGoals->goalsagainst;

            $results[] = array(
                'id'                => $team->id,
                'name'              => $team->name,
                'points'            => $team->points,
                'played'            => $team->played,
                'won'               => $team->won,
                'drawn'             => $team->drawn,
                'lost'              => $team->lost,
                'goalsFor'          => $goalsFor,
                'goalsAgainst'      => $goalsAgainst,
                'goalDifference'    => ($goalsFor - $goalsAgainst)
            );
        });

        return response()->json($results);
    }

    public function champPercantages(){
        $total = PropertyAppliance::all()->sum('property_total');
        $teams = Team::all();

        $week = Fixture::where("played", false)->orderBy('week','asc')->get()->first();

        $data = array(
            'week'          => $week,
            'percentages'   => array()
        );

        $i=0;
        foreach ($teams as $team) {
            $perc = PropertyAppliance::where('team_id', $team->id)->sum('property_total');

            $perc = round(($perc*100) / $total);

            $data['percentages'][] = array('team' => $team, 'perc' => $perc);
            $i++;
        }

        return response()->json($data);
    }

    public function makeMatch(){
        $week = Fixture::where("played", false)->orderBy('week','asc')->get()->first();
        $matches = Fixture::where("week",$week->week)->get();

        $results = $this->getMatchesResults($matches);

        return response()->json($results);
    }

    public function playAll(){
        $matches = Fixture::where("played", false)->orderBy('week','asc')->get();

        $results = $this->getMatchesResults($matches);

        return response()->json($results);
    }

    public function resetLeague(){
        Artisan::call('migrate:refresh --seed');
        return 'ok';
    }

    private function getMatchesResults($matches){
        $fieldId = 4;

        $homeGoals = 0;
        $visitorGoals = 0;

        $results = array();

        $matches->each(function($match) use ($fieldId, $homeGoals, $visitorGoals, &$results){
            for($i=0;$i<10;$i++){
                $dices = $this->diceIt();
                $field = field::find($fieldId);

                $home = $this->getCalc($match->home, $field->home_property_id);
                $visitor = $this->getCalc($match->visitor, $field->visitor_property_id);

                $homeCalc = (int) $home * (int) $dices['home'];
                $visitorCalc = (int) $visitor * (int) $dices['visitor'];

                if($homeCalc > $visitorCalc){
                    // Home got ball
                    // Get home team property_appliance and increase 1
                    $property = property::find($field->home_property_id);
                    $propertyApp = PropertyAppliance::where('team_id', $match->home)
                        -> where('property_id', $field->home_property_id)
                        ->get()
                        ->first();
                    $propertyApp->property_value += 10;
                    $propertyApp->property_total = $propertyApp->property_value * $property->ratio;
                    $propertyApp->save();
                    $fieldId++;
                }elseif($homeCalc < $visitorCalc){
                    // Visitor got ball
                    // Get visitor team property_appliance and increase 1
                    $property = property::find($field->visitor_property_id);
                    $propertyApp = PropertyAppliance::where('team_id', $match->visitor)
                        -> where('property_id', $field->visitor_property_id)
                        ->get()
                        ->first();
                    $propertyApp->property_value += 10;
                    $propertyApp->property_total = $propertyApp->property_value * $property->ratio;
                    $propertyApp->save();
                    $fieldId--;
                }

                if($fieldId==7){
                    // Home scores
                    $homeGoals++;
                    $fieldId = 4;
                }

                if($fieldId==1){
                    // Visitor scores
                    $visitorGoals++;
                    $fieldId = 4;
                }
            }

            $match->home_goals = $homeGoals;
            $match->visitor_goals = $visitorGoals;
            $match->played = true;
            $match->save();
            $homeTeam = Team::find($match->home);
            $visitorTeam = Team::find($match->visitor);

            $homeTeam->played +=1;
            $visitorTeam->played +=1;

            if($homeGoals>$visitorGoals){
                $homeTeam->won +=1;
                $homeTeam->points +=3;
                $homeTeam->save();
                $visitorTeam->lost +=1;
                $visitorTeam->save();
            }elseif($homeGoals<$visitorGoals){
                $visitorTeam->won +=1;
                $visitorTeam->points +=3;
                $visitorTeam->save();
                $homeTeam->lost +=1;
                $homeTeam->save();
            }else{
                $visitorTeam->drawn +=1;
                $visitorTeam->points +=1;
                $visitorTeam->save();
                $homeTeam->drawn +=1;
                $homeTeam->points +=1;
                $homeTeam->save();
            }

            $results[] = array(
                'home' => array(
                    'team'  => $homeTeam->name,
                    'goals' => $homeGoals
                ),
                'visitor' => array(
                    'team'  => $visitorTeam->name,
                    'goals' => $visitorGoals
                )
            );
            $homeGoals=0;
            $visitorGoals=0;
        });

        return $results;
    }
}
