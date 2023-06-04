<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;

class Route extends Model
{
    use RouteRelation,
        AsSource,
        Attachable,
        Filterable;

    protected $fillable = ['name'];
}
