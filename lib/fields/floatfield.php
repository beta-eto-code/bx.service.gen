<?php


namespace Bx\Service\Gen\Fields;


class FloatField extends BaseField
{
    public function getValue()
    {
        return $this->faker->randomFloat();
    }

    public function getType(): string
    {
        return 'float';
    }
}