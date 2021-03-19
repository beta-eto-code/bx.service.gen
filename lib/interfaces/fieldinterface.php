<?php


namespace Bx\Service\Gen\Interfaces;


interface FieldInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return SchemaInterface|null
     */
    public function getParent(): ?SchemaInterface;

    /**
     * @param SchemaInterface $schema
     * @return mixed
     */
    public function setParent(SchemaInterface $schema);
}