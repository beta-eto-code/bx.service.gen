<?php


namespace Bx\Service\Gen\Interfaces;


interface RequestDataInterface
{
    public function getValueInQuery(string $key);
    public function getValueInBody(string $key);
    public function getValueInParams(string $key);
    public function getValueByKey(string $key);
}