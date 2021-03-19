<?php


namespace Bx\Service\Gen\Fields;


class FileField extends BaseField
{
    public function getValue()
    {
        mkdir('/tmp/fake');
        return $this->faker->file('/tmp', '/tmp/fake');
    }

    public function getType(): string
    {
        return 'file';
    }
}