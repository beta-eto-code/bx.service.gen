<?php


namespace Bx\Service\Gen\Fields;


use Faker\Generator;

class StringField extends BaseField
{
    /**
     * @var int
     */
    private $limit;

    public function __construct(Generator $generator, string $name, int $limit = null)
    {
        parent::__construct($generator, $name);
        $this->limit = $limit;
    }

    public function getValue()
    {
        if ($this->limit === null) {
            return $this->faker->text;
        }

        return $this->faker->text($this->limit);
    }

    public function getType(): string
    {
        return 'string';
    }
}