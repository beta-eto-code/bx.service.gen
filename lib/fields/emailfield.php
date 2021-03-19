<?php


namespace Bx\Service\Gen\Fields;


class EmailField extends BaseField
{

    public function getValue()
    {
        return $this->faker->email;
    }

    public function getType(): string
    {
        return 'email';
    }
}