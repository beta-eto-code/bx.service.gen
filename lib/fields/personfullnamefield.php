<?php


namespace Bx\Service\Gen\Fields;


class PersonFullNameField extends BaseField
{
    /**
     * @return string
     */
    public function getValue()
    {
        return $this->faker->firstName.' '.$this->faker->lastName;
    }

    public function getType(): string
    {
        return 'full-name';
    }
}