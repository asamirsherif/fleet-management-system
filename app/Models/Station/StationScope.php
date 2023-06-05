<?php

namespace App\Models\Station;

trait StationScope {

    public function isSubStation(){
        return (bool) $this->station_parent_id;
    }
}
