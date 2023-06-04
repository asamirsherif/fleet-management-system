<?php

namespace App\Services\Transport;

use App\Models\Transport\Route;
use Illuminate\Support\Facades\DB;

class RouteService
{
    public function createRoute(array $data): Route
    {
        return Route::create($data);
    }

    public function getRouteById(int $id): ?Route
    {
        return Route::find($id);
    }

    public function updateRoute(Route $route, array $data): bool
    {
        return $route->update($data);
    }

    public function deleteRoute(Route $route): bool
    {
        return $route->delete();
    }

    public function getAllRoutes(): array
    {
        return Route::all()->toArray();
    }
}
