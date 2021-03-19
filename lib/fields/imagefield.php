<?php


namespace Bx\Service\Gen\Fields;


class ImageField extends BaseField
{
    public function getValue()
    {
        return $this->faker->imageUrl();
    }

    public function getType(): string
    {
        return 'image';
    }
}