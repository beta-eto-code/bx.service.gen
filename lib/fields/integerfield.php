<?php


namespace Bx\Service\Gen\Fields;


use Faker\Generator;

class IntegerField extends BaseField
{
    /**
     * @var int|null
     */
    private $from;
    /**
     * @var int|null
     */
    private $to;

    public function __construct(Generator $generator, string $name, int $from = null, int $to = null)
    {
        parent::__construct($generator, $name);
        $this->from = $from ?? 0;
        $this->to = $to ?? 2147483647;
    }

    public function getValue()
    {
        return $this->faker->numberBetween($this->form, $this->to);
    }

    public function getType(): string
    {
        return 'number';
    }
}