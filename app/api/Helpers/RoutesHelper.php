<?php

declare(strict_types=1);

namespace Backend\Api\Helpers;

class RoutesHelper
{
    public static function getRoutes()
    {
        $urls = self::getUrls();
        
        $request = [];
        $request['route'] = strtoupper($urls[0]);
        $request['action'] = $urls[1] ?? null;
        $request['id'] = $urls[2] ?? null;
        $request['method'] = $_SERVER['REQUEST_METHOD'];

        return $request;
    }

    public static function getUrls()
    {
        $uri = str_replace('/' . __DIR__, '', $_SERVER['REQUEST_URI']);
        
        return explode(
            '/', 
            trim($uri, '/')
        );
    }
}
