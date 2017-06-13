<?php

namespace Incognito\Routing;

class ApiRouter
{
    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var null|string
     */
    protected $namespace;

    /**
     * ApiRouter constructor.
     *
     * @param $routesFilePath
     * @param null $namespace
     */
    public function __construct($routesFilePath, $namespace = null)
    {
        $this->namespace = $namespace;

        $this->setupRoutes($routesFilePath);
    }

    /**
     * @param $routesFilePath
     */
    private function setupRoutes($routesFilePath)
    {
        $route = $this;

        include_once $routesFilePath;

        $this->registerRoutes();
    }

    /**
     * @param null $uri
     * @param null $endpoint
     * @param null $namespace
     *
     * @return \Incognito\Routing\ApiRoute
     */
    public function get($uri = null, $endpoint = null, $namespace = null)
    {
        $route = new ApiRoute('GET', $uri, $endpoint, $this->namespace, $namespace);

        $this->routes[] = $route;

        return $route;
    }

    /**
     * @param null $uri
     * @param null $endpoint
     * @param null $namespace
     *
     * @return \Incognito\Routing\ApiRoute
     */
    public function post($uri = null, $endpoint = null, $namespace = null)
    {
        $route = new ApiRoute('POST', $uri, $endpoint, $this->namespace, $namespace);

        $this->routes[] = $route;

        return $route;
    }

    /**
     * Registers the routes
     */
    private function registerRoutes()
    {
        add_action('rest_api_init', function () {
            foreach ($this->routes as $route) {
                $route->register();
            }
        });
    }
}