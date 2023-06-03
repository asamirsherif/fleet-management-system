<?php

namespace App\Orchid\Resources\Vehicle;

use App\Models\Vehicle\Vehicle;
use App\Services\Vehicle\SeatsService;
use App\Services\Vehicle\VehicleService;
use Orchid\Crud\Resource;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Crud\ResourceRequest;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Sight;

class VehicleResource extends Resource
{

    public function __construct(private VehicleService $vehicleService, private SeatsService $seatsService){
        //
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Vehicle::class;

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
        $vehicleId = request()->id;
        return [

            Select::make('type')
                ->title('Type')
                ->options(Vehicle::TYPES)
                ->required(),

            (!$vehicleId) ? Input::make('seat_count')
                ->title('Seats Count')
                ->placeholder('Enter no. of seats')
                ->mask([
                    "alias" => "numeric"
                ])
                ->value('12') //default value for robusta task
                ->required()
                ->popover('The seat number isn\'t editable')
                :
                Input::make('seat_count')->disabled(),

            Input::make('license_plate')
                ->title('License Plate')
                ->required()
                ->placeholder('Enter license plate')

        ];
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

            TD::make('type', 'Type')
                ->render(function($model){
                    return $model->type;
                }),

            TD::make('seat_count', 'Seat Count'),

            TD::make('license_plate', 'License Plate'),
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

            Sight::make('type', __('Type')),

            Sight::make("seat_count", __("Seat Count")),

            Sight::make('license_plate', __("License Plate")),

        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [

        ];
    }

    public function save(ResourceRequest $request, Model $model): void
    {
        if ($model->id) {
            $this->vehicleService->updateVehicle($model->id, $request->toArray());
        } else {
            $vechicle = $this->vehicleService->createVehicle($request->toArray());
            $this->seatsService->createSeat($vechicle);
        }
    }

    /**
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(Model $model): array
    {
        return (!$model->id) ? [
            'seat_count' => [
                'required','integer'
            ],
        ] : [];
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
