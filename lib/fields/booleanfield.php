<?php


namespace Bx\Service\Gen\Fields;


class BooleanField extends BaseField
{

    public function getValue()
    {
        return $this->faker->boolean();
    }

    public function getType(): string
    {
        return 'boolean';
    }
}