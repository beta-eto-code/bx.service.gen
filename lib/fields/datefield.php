<?php


namespace Bx\Service\Gen\Fields;


class DateField extends DateTimeField
{
    public function getValue()
    {
        return $this->getDateTime()->format('Y-m-d');
    }

    public function getType(): string
    {
        return 'date';
    }
}