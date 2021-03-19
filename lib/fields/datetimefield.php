<?php


namespace Bx\Service\Gen\Fields;


use DateTime;
use Faker\Generator;

class DateTimeField extends BaseField
{
    /**
     * @var int|null
     */
    private $from;
    /**
     * @var int|null
     */
    private $to;

    public function __construct(Generator $generator, string $name, string $from = null, string $to = null)
    {
        parent::__construct($generator, $name);
        $this->from = $from ?? '-30 years';
        $this->to = $to ?? 'now';
    }

    public function getValue()
    {
        return $this->getDateTime()->format('c');
    }

    public function getDateTime(): DateTime
    {
        return $this->faker->dateTimeBetween($this->from, $this->to);
    }

    public function getType(): string
    {
        return 'date-time';
    }
}