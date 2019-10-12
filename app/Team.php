<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function fixturesHome(){
        return $this->hasMany(Fixture::class, 'home', 'id');
    }

    public function fixturesVisitor(){
        return $this->hasMany(Fixture::class, 'visitor', 'id');
    }
}
