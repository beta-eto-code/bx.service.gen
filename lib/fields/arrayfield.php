<?php


namespace Bx\Service\Gen\Fields;


use Bx\Service\Gen\Interfaces\FieldInterface;
use Faker\Generator;

class ArrayField extends BaseField
{
    /**
     * @var FieldInterface
     */
    private $field;
    /**
     * @var int|null
     */
    private $limit;

    public function __construct(Generator $generator, string $name, FieldInterface $field, int $limit = 30)
    {
        parent::__construct($generator, $name);
        $this->field = $field;
        $this->limit = $limit;
    }

    /**
     * @return array
     */
    public function getValue()
    {
        $result = [];
        $limit = $this->faker->numberBetween(0, $this->limit);
        while ($limit-- > 0) {
            $result[] = $this->field->getValue();
        }

        return $result;
    }

    public function getType(): string
    {
        return 'array';
    }
}