<?php


namespace Bx\Service\Gen\Routes;


use Bx\Service\Gen\Interfaces\RequestDataInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestData implements RequestDataInterface
{
    /**
     * @var ServerRequestInterface
     */
    private $request;
    /**
     * @var array|null
     */
    private $parsedPostData;
    /**
     * @var array
     */
    private $queryData;

    public function __construct(ServerRequestInterface $request, array $parsedPostData = null)
    {
        $this->request = $request;
        $this->queryData = $request->getQueryParams();
        $this->parsedPostData = $parsedPostData ?? [];
    }

    public function getValueInQuery(string $key)
    {
        return $this->queryData[$key] ?? null;
    }

    public function getValueInBody(string $key)
    {
        return $this->parsedPostData[$key] ?? null;
    }

    public function getValueInParams(string $key)
    {
        return $this->request->getAttribute($key, null);
    }

    public function getValueByKey(string $key)
    {
        if ($value = $this->getValueInQuery($key)) {
            return $value;
        }

        if ($value = $this->getValueInBody($key)) {
            return $value;
        }

        if ($value = $this->getValueInParams($key)) {
            return $value;
        }

        return null;
    }
}