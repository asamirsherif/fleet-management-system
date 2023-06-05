<?php

namespace App\Http\Controllers\Api\V1\Booking;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Services\Booking\BookingService;
use App\Services\Station\StationService;
use App\Services\Transport\RouteService;
use App\Http\Resources\Api\V1\Station\StationResource;
use App\Http\Requests\V1\Booking\AvailableRouteRequest;
use App\Http\Resources\Api\V1\Transport\SubRouteResource;
use App\Http\Requests\Booking\BookTripRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Booking\BookingResource;

class BookingController extends ApiController
{

    public function __construct(
        private StationService $stationService,
        private RouteService $routeService,
        private BookingService $bookingService
    ){
        $this->middleware('auth:api')->only(['createBookingByUser']);
    }

    public function getAvailableRoutes(AvailableRouteRequest $request){
        $subRoutes = $this->routeService->getAvailableSubroutes($request->start_station_id,$request->end_station_id);
        return $this->handleResponse(SubRouteResource::collection($subRoutes));
    }

    public function getAvailableStations(){
        $stations = $this->stationService->getAllStations();
        return $this->handleResponse(StationResource::collection($stations));
    }

    public function createBookingByUser(BookTripRequest $request){
        $user = Auth::user();
        $request->merge(['user_id' => $user->id]);
        $booking = $this->bookingService->createBooking($request);
        return $this->handleResponse(BookingResource::collection($booking));
    }
}
