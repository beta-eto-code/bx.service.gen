<?php


namespace Bx\Service\Gen\Interfaces;


use BX\Router\Interfaces\RouterInterface;
use IteratorAggregate;

interface RouteCollectionInterface extends IteratorAggregate
{
    /**
     * @param string $path
     * @param string|null $method
     * @return RouteInterface|null
     */
    public function getByPath(string $path, string $method = null): ?RouteInterface;

    /**
     * @param string $operationId
     * @return RouteInterface|null
     */
    public function getByOperationId(string $operationId): ?RouteInterface;

    /**
     * @param string ...$groupCodeList
     * @return RouteCollectionInterface
     */
    public function filterByGroups(string ...$groupCodeList): RouteCollectionInterface;

    /**
     * @param string ...$methodList
     * @return RouteCollectionInterface
     */
    public function filterByMethods(string ...$methodList): RouteCollectionInterface;

    /**
     * @param RouteInterface $route
     * @return RouteCollectionInterface
     */
    public function addRoute(RouteInterface $route): RouteCollectionInterface;

    /**
     * @param string ...$pathList
     * @return RouteCollectionInterface
     */
    public function excludeByPath(string ...$pathList): RouteCollectionInterface;

    /**
     * @param string ...$pathList
     * @return RouteCollectionInterface
     */
    public function wherePath(string ...$pathList): RouteCollectionInterface;

    /**
     * @param string ...$operationId
     * @return RouteCollectionInterface
     */
    public function excludeByOperationId(string ...$operationId): RouteCollectionInterface;

    /**
     * @param string ...$operationId
     * @return RouteCollectionInterface
     */
    public function whereOperationId(string ...$operationId): RouteCollectionInterface;

    /**
     * @param RouterInterface $router
     * @return mixed
     */
    public function compile(RouterInterface $router);

    /**
     * @return mixed
     */
    public function generateControllers();
}