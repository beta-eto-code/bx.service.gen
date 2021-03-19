<?php


namespace Bx\Service\Gen\Fields;


use Faker\Generator;

class EnumField extends BaseField
{
    /**
     * @var array
     */
    private $values;

    public function __construct(Generator $generator, string $name, array $values)
    {
        parent::__construct($generator, $name);
        $this->values = $values;
    }

    public function getValue()
    {
        return $this->faker->randomElement($this->values);
    }

    public function getType(): string
    {
        return 'enum';
    }
}