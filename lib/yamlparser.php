<?php

namespace Bx\Service\Gen;

use Bx\Service\Gen\Interfaces\ParserInterface;
use Bx\Service\Gen\Interfaces\RouteCollectionInterface;
use Bx\Service\Gen\Routes\Factory;
use Bx\Service\Gen\Routes\RouteCollection;
use Exception;
use Symfony\Component\Yaml\Yaml;

class YamlParser implements ParserInterface
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var array
     */
    private $fullSchema;

    /**
     * YamlParser constructor.
     * @param string $path
     * @throws Exception
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        if (!file_exists($path)) {
            throw new Exception("File {$path} does not exists!");
        }
        $this->fullSchema = Yaml::parseFile($path);
    }

    /**
     * @return RouteCollectionInterface
     */
    public function getRoutes(): RouteCollectionInterface
    {
        $collection = new RouteCollection;
        foreach ($this->fullSchema['paths'] as $path => $pathData) {
            foreach ($pathData as $method => $routeData) {
                $collection->addRoute(Factory::createRoute($path, $method, $routeData, $this->fullSchema));
            }
        }

        return $collection;
    }
}