<?php


namespace Bx\Service\Gen\Fields;


use Bx\Service\Gen\Interfaces\FieldInterface;
use Bx\Service\Gen\Interfaces\SchemaInterface;
use Faker\Factory;
use Faker\Generator;

abstract class BaseField implements FieldInterface
{
    /**
     * @var Generator
     */
    protected $faker;
    /**
     * @var SchemaInterface
     */
    private $parent;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $type;

    public function __construct(Generator $generator, string $name)
    {
        $this->faker = $generator;
        $this->name = $name;
    }

    abstract public function getValue();

    abstract public function getType(): string;

    public function getName(): string
    {
        return (string)$this->name;
    }

    public function getParent(): ?SchemaInterface
    {
        return $this->parent ?? null;
    }

    public function setParent(SchemaInterface $schema)
    {
        $this->parent = $schema;
    }
}