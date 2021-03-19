<?php


namespace Bx\Service\Gen\Interfaces;


use BX\Router\Interfaces\RouterInterface;

interface RouteInterface
{
    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string|null
     */
    public function getOperationId(): ?string;

    /**
     * @return array
     */
    public function getGroups(): array;

    /**
     * @return SchemaInterface|null
     */
    public function getSuccessSchema(): ?SchemaInterface;

    /**
     * @param string $code
     * @return SchemaInterface|null
     */
    public function getFailSchema(string $code): ?SchemaInterface;

    /**
     * @param RouterInterface $router
     * @return mixed
     */
    public function compile(RouterInterface $router);

    /**
     * @return mixed
     */
    public function generateController();

    /**
     * @param string $selector
     * @return FieldInterface|null
     */
    public function findField(string $selector): ?FieldInterface;
}