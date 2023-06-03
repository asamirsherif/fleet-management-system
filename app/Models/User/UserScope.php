<?php

namespace App\Models\User;

use App\Models\Polymorphic\Status;
use Illuminate\Contracts\Database\Eloquent\Builder;

trait UserScope
{
    public function isActive()
    {
        return $this->status->status == Status::ACTIVE;
    }

    public function isLocked()
    {
        return $this->status->status == Status::LOCKED;
    }

    public function isAwaitActivation()
    {
        return $this->status->status == Status::AWAIT_ACTIVATION;
    }

    public function isDeactived()
    {
        return $this->status->status == Status::DEACTIVATED;
    }

    public function scopeHasStatus(Builder $query,$status){
        $query->whereHas('status',function($q) use($status){
            $q->where('status',$status);
        });
    }
}
