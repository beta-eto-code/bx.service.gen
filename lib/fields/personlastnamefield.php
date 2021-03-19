<?php


namespace Bx\Service\Gen\Fields;


class PersonLastNameField extends BaseField
{

    public function getValue()
    {
        return $this->faker->lastName;
    }

    public function getType(): string
    {
        return 'last-name';
    }
}