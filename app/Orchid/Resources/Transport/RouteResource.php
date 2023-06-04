<?php

namespace App\Orchid\Resources\Transport;

use App\Models\Station\Station;
use App\Models\Transport\Route;
use App\Models\Transport\RouteStation;
use App\Services\Transport\RouteService;
use App\Services\Transport\RouteStationService;
use Orchid\Crud\Resource;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Relation;
use Orchid\Crud\ResourceRequest;
use Illuminate\Database\Eloquent\Model;
use Orchid\Support\Facades\Toast;

class RouteResource extends Resource
{

    public function __construct(private RouteService $routeService, private RouteStationService $routeStationService)
    {

    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Route::class;

    /**
     * Get the resource should be displayed in the navigation
     *
     * @return bool
     */
    public static function displayInNavigation(): bool
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        $routeStationData = [];

        if($routeId = request()->id)
            $routeStationData = $this->routeStationData($routeId);

        return [

            Matrix::make('stations')
                ->title('Route Stations')
                ->popover('Stations should be in an orderly manner!')
                ->value($routeStationData)
                ->columns([
                    'ID',
                    'Start Station',
                    'End Station',
                    'Price',
                ])
                ->fields([
                    "ID" => Input::make('id')->name('id')->hidden(),
                    "Start Station" => Relation::make("start_station_id")
                        ->name('start_station_id')
                        ->fromModel(Station::class, "name", "id")
                        ->chunk(25)
                        ->required(),

                    "End Station" => Relation::make("end_station_id")
                        ->name('end_station_id')
                        ->fromModel(Station::class, "name", "id")
                        ->chunk(25)
                        ->required(),

                    "Price" => Input::make('price')
                        ->name('Price')
                        ->mask([
                            "alias" => "numeric"
                        ])
                ]),

                Input::make('name')
                ->title('Route Name')
                ->required()
                ->placeholder('Enter Route Name'),
        ];
    }


    public function routeStationData($routeId){
        return $this->routeStationService->matrixEditData($routeId);
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),

            TD::make('name'),

            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id', "ID"),

            Sight::make('name', __('Name')),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    public function rules(Model $model): array
    {
        return [
            'stations.*.Price' => 'required',
            'stations.*.End Station' => 'required|different:stations.*.Start Station',
            'stations.*.Start Station' => 'required',
        ];
    }

    public function save(ResourceRequest $request, Model $model): void
    {
        $routeData = ['name' => $request->name];
        $routeStationData = $request->stations;


        if ($model->id) {
            $this->routeService->updateRoute($model, $routeData);
            $this->routeStationService->updateRouteStation($model->id, $routeStationData);
        } else {
            $route = $this->routeService->createRoute($routeData);
            $this->routeStationService->createRouteStation($route->id, $routeStationData);
        }
    }

    /**
     * Action to delete a model
     *
     * @param Model $model
     *
     * @throws Exception
     */
    public function onDelete(Model $model)
    {
        $model->delete();
    }

}
