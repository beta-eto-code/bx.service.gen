<?php


namespace Bx\Service\Gen\Fields;


use Faker\Generator;

class IncrementField extends IntegerField
{
    /**
     * @var int
     */
    private $current;
    /**
     * @var int
     */
    private $stepFrom;
    /**
     * @var int
     */
    private $stepTo;

    /**
     * @param int|null $from
     * @param int|null $to
     */
    public function setStepBetween(int $from = null, int $to = null)
    {
        $this->stepFrom = $from;
        $this->stepTo = $to;
    }

    public function getValue()
    {
        if (is_null($this->current)) {
            return $this->current = parent::getValue();
        }

        return $this->current += $this->faker->numberBetween($this->stepFrom ?? 1, $this->stepTo ?? 1);
    }

    public function getType(): string
    {
        return 'increment';
    }
}