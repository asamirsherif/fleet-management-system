<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Input::make('user.first_name')
                ->type('first_name')
                ->required()
                ->title(__('First Name'))
                ->placeholder(__('First Name')),

            Input::make('user.last_name')
                ->type('last_name')
                ->required()
                ->title(__('Last Name'))
                ->placeholder(__('Last Name')),

            Input::make('user.phone_number')
                ->type('phone_number')
                ->required()
                ->title(__('Phone Number'))
                ->placeholder(__('Phone Number')),
        ];
    }
}
