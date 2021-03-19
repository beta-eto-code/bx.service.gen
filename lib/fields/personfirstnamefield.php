<?php


namespace Bx\Service\Gen\Fields;


class PersonFirstNameField extends BaseField
{

    public function getValue()
    {
        return $this->faker->firstName();
    }

    public function getType(): string
    {
        return 'first-name';
    }
}