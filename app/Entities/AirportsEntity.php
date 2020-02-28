<?php

namespace Flashpoint\Instance\Entities;

use Flashpoint\Fuel\Entities\Definitions\Collection;
use Flashpoint\Fuel\Entities\Definitions\Field;
use Flashpoint\Fuel\Entities\Definitions\Input\CheckboxInput;
use Flashpoint\Fuel\Entities\Definitions\Input\MultiSelectInput;
use Flashpoint\Fuel\Entities\Definitions\Input\SelectInput;
use Flashpoint\Fuel\Entities\Definitions\Input\TextInput;
use Flashpoint\Fuel\Entities\Definitions\Section;
use Flashpoint\Fuel\Entities\Helpers\PluralEntity;
use Flashpoint\Fuel\State;
use Flashpoint\Instance\Models\Airport;
use Flashpoint\Instance\Models\Flight;
use Jenssegers\Mongodb\Eloquent\Builder;

/**
 * Class FlightsEntity
 * @package Flashpoint\Instance\Entities
 * @property Flight $store
 */
class AirportsEntity extends PluralEntity
{
    public static function title()
    {
        return 'Airports';
    }

    public static function description()
    {
        return 'All our airports';
    }

    public static function collection(Collection $collection)
    {
        $collection->includeField(function (Field $field) {
            $field
                ->named('name')
                ->labeled('Name')
                ->containing(function (State $state) {
                    return $state->get('name');
                });
        });

        $collection->includeField(function (Field $field) {
            $field
                ->named('code')
                ->labeled('Code')
                ->containing(function (State $state) {
                    return $state->get('code');
                });
        });

        $collection->includeField(function (Field $field) {
            $field
                ->named('type')
                ->labeled('Type')
                ->containing(function (State $state) {
                    return $state->get('is_virtual', false) ? 'Virtual' : 'Real';
                });
        });
    }

    public function sectionMain(Section $section)
    {
        $section->includeField(function (Field $field) {
            $field
                ->named('name')
                ->labeled('Name')
                ->containing($this->state->get('name'))
                ->withInput(TextInput::class);
        });

        $section->includeField(function (Field $field) {
            $field
                ->named('code')
                ->labeled('Code')
                ->containing($this->state->get('code'))
                ->withInput(TextInput::class);
        });

        $section->includeField(function (Field $field) {
            $isVirtual = (bool)$this->state->get('is_virtual', false);
            $field
                ->named('is_virtual')
                ->labeled('Virtual')
                ->containing($isVirtual)
                ->withInput(CheckboxInput::class, function (CheckboxInput $input) use ($isVirtual){
                    $input->containing($isVirtual ? 'Is a virtual station' : 'Is a real station');
                });
        });

        $section->includeField(function (Field $field) {
            $field
                ->named('child_airports')
                ->labeled('Child Airports')
                ->containing($this->state->get('child_airports', []))
                ->withInput(MultiSelectInput::class, function (SelectInput $select) {
                    $select->options(
                        Airport::query()->when($this->store->exists, function(Builder $builder) {
                            return $builder->where('_id', '!=', $this->store->id);
                        })->get()->pluck('name', 'id')->toArray()
                    );
                });

            if($this->state->get('is_virtual', false)) {
                $field->shown();
            } else {
                $field->hidden();
            }
        });
    }
}
