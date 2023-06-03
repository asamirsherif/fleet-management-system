<?php

namespace App\Models\Traits;

use App\Models\Polymorphic\Status;

trait CommonRelation
{
    public function status()
    {
        return $this->morphOne(Status::class, 'object');
    }
}
