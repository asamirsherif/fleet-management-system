<?php

namespace App\Orchid\Resources\Station;

use Orchid\Crud\Resource;
use Orchid\Screen\TD;
use App\Models\Station\Station;
use App\Services\Station\StationService;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Map;
use Orchid\Crud\ResourceRequest;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Sight;

class StationResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Station::class;

    public function __construct(private StationService $stationService)
    {
    }


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
     * Get the columns displayed by the resource.
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            TD::make('name', __('Name')),

            TD::make('place','Location')
            ->render(function ($model){
                return '<a  style="color:blue;"
                            href="https://maps.google.com/?q='. $model->longitude . ',' . $model->latitude . '"> '. $model->longitude . ',' . $model->latitude.'</a> ';
            }),

            TD::make('station_parent_id', __('Parent Station'))
            ->render(function ($model) {
                return $model->parent?->name ?? '  None  ';
            }),

            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('name')
                ->title('Name')
                ->placeholder('Enter station name')
                ->required(),

            Relation::make('parent_station_id')
                ->title('Parent Station')
                ->fromModel(Station::class, "name"),

            Map::make('place')
                ->required()
                ->title('Object on the map')
                ->help('Enter the coordinates, or use the search'),

        ];
    }

    /**
     * Get the legend text for the resource.
     *
     * @return string
     */
    public function legend(): array
    {
        return [
            Sight::make('id', "ID"),

            Sight::make('name', __('Name')),

            Sight::make("parent_station_id", __("Parent Station"))
                ->render(function ($model) {
                    return $model->parent?->name ?? 'None';
                }),

        ];
    }


    /**
     * Perform any actions before storing the resource.
     *
     * @param Station $station
     */
    public function beforeStore(Station $station)
    {

    }

    /**
     * Perform any actions after storing the resource.
     *
     * @param Station $station
     */
    public function afterStore(Station $station)
    {
        Toast::info('Station created!');
    }

    public function save(ResourceRequest $request, Model $model): void
    {
        $request->merge([
            'longitude' =>  $request->place['longitude'],
            'latitude' => $request->place['latitude']
            ]);

        // on update
        if ($model->id) {
            $this->stationService->updateStation($model->id, $request->toArray());
        } else {
            $this->stationService->createStation($request->toArray());
        }
    }

    /**
     * Perform any actions after updating the resource.
     *
     * @param Station $station
     */
    public function afterUpdate(Station $station)
    {
        Toast::info('Station updated!');
    }

    /**
     * Perform any actions before deleting the resource.
     *
     * @param Station $station
     */
    public function beforeDelete(Station $station)
    {
        // Perform any additional actions before deleting the station resource
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

    /**
     * Perform any actions after deleting the resource.
     *
     * @param Station $station
     */
    public function afterDelete(Station $station)
    {
        Toast::info('Station deleted!');
    }
}
