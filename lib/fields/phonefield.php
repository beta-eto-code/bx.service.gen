<?php


namespace Bx\Service\Gen\Fields;


class PhoneField extends BaseField
{
    public function getValue()
    {
        return $this->faker->phoneNumber;
    }

    public function getType(): string
    {
        return 'phone';
    }
}