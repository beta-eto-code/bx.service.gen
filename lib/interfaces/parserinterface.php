<?php


namespace Bx\Service\Gen\Interfaces;


use Iterator;

interface ParserInterface
{
    public function getRoutes(): RouteCollectionInterface;
}