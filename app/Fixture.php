<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    public function homeTeam(){
        return $this->hasOne('App\Team', 'id','home');
    }

    public function visitorTeam(){
        return $this->hasOne('App\Team', 'id','visitor');
    }
}
