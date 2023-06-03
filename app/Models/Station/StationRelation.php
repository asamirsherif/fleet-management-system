<?php

namespace App\Models\Station;

use App\Models\Station\Station;

trait StationRelation {

    public function parent()
    {
        return $this->belongsTo(Station::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Station::class, 'parent_id');
    }

    public function subStations()
    {
        return $this->children();
    }
}
