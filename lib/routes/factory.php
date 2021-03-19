<?php


namespace Bx\Service\Gen\Routes;


use Bx\Service\Gen\Interfaces\RouteInterface;
use Bx\Service\Gen\Fields\Factory as FieldFactory;

class Factory
{
    /**
     * @param string $path
     * @param string $method
     * @param array $data
     * @param array $fullSchema
     * @return RouteInterface
     */
    public static function createRoute(string $path, string $method, array $data, array $fullSchema): RouteInterface
    {
        $operationId = $data['operationId'] ?? '';
        $groups = $data['tags'] ?? [];

        $responses = [];
        foreach (($data['responses'] ?? []) as $code => $responseData) {
            $ref = $responseData['$ref'];
            if (!empty($ref)) {
                $responseData = FieldFactory::getRefData($ref, $fullSchema);
            }

            $schemaData = current($responseData['content'] ?? [])['schema'] ?? null;

            if (!empty($schemaData)) {
                $responses[$code] = FieldFactory::createField($schemaData, $fullSchema);
            }
        }


        return new BaseRoute($method, $path, $operationId, $groups, $responses);
    }
}