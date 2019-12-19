<?php

namespace Sbine\RouteViewer\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Api
{
    /**
     * Return all the registered routes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoutes()
    {
        $client = new \GuzzleHttp\Client();
        $url = config('app.portal_url').'/api/routes';

        $result = $client->get($url,
            [
                'verify' => false
            ]);

        $response = json_decode($result->getBody(), true);

        return response()->json($response);
    }


    /**
     * Return all the registered routes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoutesAdmin()
    {
        $routes = collect(Route::getRoutes())->map(function ($route, $index) {
            $routeName = $route->action['as'] ?? '';
            if (Str::endsWith($routeName, '.')) {
                $routeName = '';
            }

            $routeMiddleware = $route->action['middleware'] ?? [];
            if (! is_array($routeMiddleware)) {
                $routeMiddleware = [$routeMiddleware];
            }

            return [
                'uri' => $route->uri,
                'as' => $routeName,
                'methods' => $route->methods,
                'action' => $route->action['uses'] ?? '',
                'middleware' => $routeMiddleware,
            ];
        });

        return response()->json($routes);
    }
}
