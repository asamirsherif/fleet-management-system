<?php

namespace App\Models\Polymorphic;

trait PolymorphicRelation
{
    /**
     * Get the owning object model.
     */
    public function object()
    {
        return $this->morphTo();
    }
}
