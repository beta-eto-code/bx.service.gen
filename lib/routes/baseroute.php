<?php


namespace Bx\Service\Gen\Routes;


use BX\Router\BaseController;
use BX\Router\Interfaces\RouterInterface;
use Bx\Service\Gen\Interfaces\FieldInterface;
use Bx\Service\Gen\Interfaces\RouteInterface;
use Bx\Service\Gen\Interfaces\SchemaInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BaseRoute implements RouteInterface
{
    /**
     * @var string[]
     */
    private static $successKeys = ['200', 'ok', 'success'];
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $operationId;
    /**
     * @var string[]
     */
    private $groups;
    /**
     * @var SchemaInterface[]|array
     */
    private $schemaList;

    /**
     * BaseRoute constructor.
     * @param string $type
     * @param string $path
     * @param string $operationId
     * @param string[]|array $groups
     * @param SchemaInterface[]|array $schemaList
     */
    public function __construct(
        string $type,
        string $path,
        string $operationId,
        array $groups,
        array $schemaList
    )
    {
        $this->type = $type;
        $this->path = $path;
        $this->operationId = $operationId;
        $this->groups = $groups;
        $this->schemaList = $schemaList;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string|null
     */
    public function getOperationId(): ?string
    {
        return $this->operationId;
    }

    /**
     * @return array|string[]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    public function getSuccessSchema(): ?SchemaInterface
    {
        if (empty($this->schemaList)) {
            return null;
        }

        if (count($this->schemaList) === 1) {
            return current($this->schemaList);
        }

        foreach(static::$successKeys as $key) {
            if (!empty($this->schemaList[$key])) {
                return $this->schemaList[$key];
            }
        }

        return null;
    }

    public function getFailSchema(string $code): ?SchemaInterface
    {
        if (count($this->schemaList) < 2 || in_array($code, static::$successKeys)) {
            return null;
        }

        return $this->schemaList[$code] ?? null;
    }

    public function compile(RouterInterface $router)
    {
        $controller = new class($this) extends BaseController {
            /**
             * @var RouteInterface
             */
            private $route;

            public function __construct(RouteInterface $route)
            {
                $this->route = $route;
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                $successSchema = $this->route->getSuccessSchema();
                $successSchema->setRequestData(new RequestData($request, $this->getParsedPostData($request)));

                $response = $this->appFactory->createResponse();
                $response->getBody()->write(
                    json_encode(
                        $successSchema->getValue(),
                        JSON_UNESCAPED_UNICODE
                    )
                );

                return $response->withHeader('Content-Type', 'application/json');
            }
        };

        $method = strtolower($this->getMethod());
        switch ($method) {
            case 'post':
                $router->post($this->getPath(), $controller);
                break;
            case 'put':
                $router->put($this->getPath(), $controller);
                break;
            case 'delete':
                $router->delete($this->getPath(), $controller);
                break;
            default:
                $router->get($this->getPath(), $controller);
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function generateController()
    {
        throw new Exception('Not implemented!');
    }

    /**
     * @param string $selector
     * @return FieldInterface|null
     */
    public function findField(string $selector): ?FieldInterface
    {
        foreach ($this->schemaList as $schema) {
            $field = $schema->findField($selector);
            if ($field instanceof FieldInterface) {
                return $field;
            }
        }

        return null;
    }
}