<?php

namespace Flashpoint\Instance\Entities;

use Flashpoint\Fuel\Entities\Definitions\Collection;
use Flashpoint\Fuel\Entities\Definitions\CollectionField;
use Flashpoint\Fuel\Entities\Definitions\Field;
use Flashpoint\Fuel\Entities\Definitions\Input\RichTextInput;
use Flashpoint\Fuel\Entities\Definitions\Input\SelectInput;
use Flashpoint\Fuel\Entities\Definitions\Input\TextInput;
use Flashpoint\Fuel\Entities\Definitions\Section;
use Flashpoint\Fuel\Entities\Helpers\PluralEntity;
use Flashpoint\Fuel\State;
use Flashpoint\Instance\Models\Airport;
use Flashpoint\Instance\Models\Flight;

/**
 * Class FlightsEntity
 * @package Flashpoint\Instance\Entities
 * @property Flight $store
 */
class FlightsEntity extends PluralEntity
{
    public static function title()
    {
        return 'Flights';
    }

    public static function description()
    {
        return 'Flights testing';
    }

    public static function collection(Collection $collection)
    {
        $collection->includeField(function (Field $field) {
            $field
                ->named('route')
                ->labeled('Route')
                ->containing(function (State $state) {
                    if($state->get('origin') && $state->get('destination')) {
                        $origin = Airport::query()->find($state->get('origin'));
                        $origin = $origin ? "{$origin->name} ({$origin->code})" : 'Unknown';

                        $destination = Airport::query()->find($state->get('destination'));
                        $destination = $destination ? "{$destination->name} ({$destination->code})" : 'Unknown';

                        return "{$origin} -> {$destination}";
                    } else {
                        return null;
                    }
                });
        });
        $collection->includeField(function (Field $field) {
            $field
                ->named('airline')
                ->labeled('Airline')
                ->containing(function (State $state) {
                    return $state->get('other_airline', null) ? $state->get('other_airline') : $state->get('airline');
                });
        });
        $collection->includeField(function (CollectionField $field) {
            $field
                ->named('flight_number')
                ->labeled('Flight Number')
                ->containing(function (State $state) {
                    return $state->get('flight_number');
                });
        });
    }

    public function sectionMain(Section $section)
    {
        $section->includeField(function (Field $field) {
            $field
                ->named('airline')
                ->labeled('Airline')
                ->containing($this->state->get('airline'))
                ->withInput(SelectInput::class, function (SelectInput $select) {
                    $select->options(Flight::$airlines + ['OTHER' => 'Other']);
                });
        });

        $section->includeField(function (Field $field) {
            $field
                ->named('other_airline')
                ->labeled('Other Airline')
                ->containing($this->state->get('other_airline'))
                ->withInput(TextInput::class);

            if ($this->state->get('airline') === 'OTHER') {
                $field->shown();
            } else {
                $field->hidden();
            }
        });

        $section->includeField(function (Field $field) {
            $field
                ->named('flight_number')
                ->labeled('Flight Number')
                ->containing($this->state->get('flight_number'))
                ->withInput(TextInput::class);
        });

        $section->includeField(function (Field $field) {
            $field
                ->named('origin')
                ->labeled('Origin Code')
                ->containing($this->state->get('origin'))
                ->withInput(SelectInput::class, function (SelectInput $select) {
                    $select->options(Airport::all()->pluck('name', 'id')->toArray());
//                    $select->options(Airport::query()->where('is_virtual', '=', true)->pluck('name', 'id')->toArray());
                });
        });

        $section->includeField(function (Field $field) {
            $field
                ->named('destination')
                ->labeled('Destination Code')
                ->containing($this->state->get('destination'))
                ->withInput(SelectInput::class, function (SelectInput $select) {
                    $select->options(Airport::all()->pluck('name', 'id')->toArray());
                });
        });

        $section->includeField(function (Field $field) {
           $field
               ->named('description')
               ->labeled('Description')
               ->containing($this->state->get('description'))
               ->withInput(RichTextInput::class);
        });
    }
}
