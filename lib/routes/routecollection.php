<?php


namespace Bx\Service\Gen\Routes;


use ArrayIterator;
use BX\Router\Interfaces\RouterInterface;
use Bx\Service\Gen\Interfaces\RouteCollectionInterface;
use Bx\Service\Gen\Interfaces\RouteInterface;
use Exception;
use Traversable;

class RouteCollection implements RouteCollectionInterface
{
    /**
     * @var RouteInterface[]
     */
    private $routeList;

    /**
     * RouteCollection constructor.
     * @param RouteInterface ...$routeList
     */
    public function __construct(RouteInterface ...$routeList)
    {
        $this->routeList = $routeList ?? [];
    }

    /**
     * @return RouteInterface[]|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->routeList);
    }

    /**
     * @param string $path
     * @param string|null $method
     * @return RouteInterface|null
     */
    public function getByPath(string $path, string $method = null): ?RouteInterface
    {
        foreach ($this->routeList as $route) {
            if ($route->getPath() === $path) {
                if ($method !== null && $method !== $route->getMethod()) {
                    continue;
                }

                return $route;
            }
        }

        return null;
    }

    /**
     * @param string $operationId
     * @return RouteInterface|null
     */
    public function getByOperationId(string $operationId): ?RouteInterface
    {
        foreach ($this->routeList as $route) {
            if ($route->getOperationId() === $operationId) {
                return $route;
            }
        }

        return null;
    }

    /**
     * @param string ...$groupCodeList
     * @return RouteCollectionInterface
     */
    public function filterByGroups(string ...$groupCodeList): RouteCollectionInterface
    {
        $list = [];
        foreach ($this->routeList as $route) {
            foreach ($groupCodeList as $groupCode) {
                if (in_array($groupCode, $route->getGroups())) {
                    $list[] = $route;
                    break;
                }
            }
        }

        return new static(...$list);
    }

    /**
     * @param string ...$methodList
     * @return RouteCollectionInterface
     */
    public function filterByMethods(string ...$methodList): RouteCollectionInterface
    {
        $list = [];
        foreach ($this->routeList as $route) {
            if (in_array($route->getMethod(), $methodList)) {
                $list[] = $route;
            }
        }

        return new static(...$list);
    }

    /**
     * @param RouteInterface $route
     * @return RouteCollectionInterface
     */
    public function addRoute(RouteInterface $route): RouteCollectionInterface
    {
        $this->routeList[] = $route;
        return $this;
    }

    /**
     * @param string ...$pathList
     * @return RouteCollectionInterface
     */
    public function excludeByPath(string ...$pathList): RouteCollectionInterface
    {
        $list = [];
        foreach ($this->routeList as $route) {
            if (!in_array($route->getPath(), $pathList)) {
                $list[] = $route;
            }
        }

        return new static(...$list);
    }

    /**
     * @param string ...$pathList
     * @return RouteCollectionInterface
     */
    public function wherePath(string ...$pathList): RouteCollectionInterface
    {
        $list = [];
        foreach ($this->routeList as $route) {
            if (in_array($route->getPath(), $pathList)) {
                $list[] = $route;
            }
        }

        return new static(...$list);
    }

    /**
     * @param string ...$operationId
     * @return RouteCollectionInterface
     */
    public function excludeByOperationId(string ...$operationId): RouteCollectionInterface
    {
        $list = [];
        foreach ($this->routeList as $route) {
            if (!in_array($route->getOperationId(), $operationId)) {
                $list[] = $route;
            }
        }

        return new static(...$list);
    }

    /**
     * @param string ...$operationId
     * @return RouteCollectionInterface
     */
    public function whereOperationId(string ...$operationId): RouteCollectionInterface
    {
        $list = [];
        foreach ($this->routeList as $route) {
            if (in_array($route->getOperationId(), $operationId)) {
                $list[] = $route;
            }
        }

        return new static(...$list);
    }

    /**
     * @param RouterInterface $router
     * @return mixed|void
     */
    public function compile(RouterInterface $router)
    {
        foreach ($this->routeList as $route) {
            $route->compile($router);
        }
    }

    /**
     * @return mixed|void
     * @throws Exception
     */
    public function generateControllers()
    {
        throw new Exception('Not implemented!');
    }
}