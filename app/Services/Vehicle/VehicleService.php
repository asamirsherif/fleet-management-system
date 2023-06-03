<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle\Vehicle;

/**
 * Class VehicleService
 * @package App\Services
 */
class VehicleService
{
    /**
     * Create a new vehicle.
     *
     * @param array $data
     * @return Vehicle
     */
    public function createVehicle(array $data): Vehicle
    {
        return Vehicle::create($data);
    }

    /**
     * Update an existing vehicle.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateVehicle(int $id, array $data): bool
    {
        $vehicle = Vehicle::findOrFail($id);
        return $vehicle->update($data);
    }

    /**
     * Delete a vehicle.
     *
     * @param int $id
     * @return bool|null
     */
    public function deleteVehicle(int $id): ?bool
    {
        $vehicle = Vehicle::findOrFail($id);
        return $vehicle->delete();
    }
}
