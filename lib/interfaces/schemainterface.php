<?php


namespace Bx\Service\Gen\Interfaces;


interface SchemaInterface extends FieldInterface, RequestDataSetterInterface
{
    /**
     * @param FieldInterface $field
     * @return mixed
     */
    public function addField(FieldInterface $field);

    /**
     * @return FieldInterface[]
     */
    public function getChildList(): array;

    /**
     * @param string $selector
     * @return FieldInterface|null
     */
    public function findField(string $selector): ?FieldInterface;
}