<?php

namespace Incognito\Routing;

class Router
{
    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var array
     */
    protected $templates = [];

    /**
     * @var null
     */
    protected $namespace;

    /**
     * Router constructor.
     *
     * @param null $routesFilePath
     * @param null $namespace
     */
    public function __construct($routesFilePath = null, $namespace = null)
    {
        $this->namespace = $namespace;

        $this->registerRoutes($routesFilePath);
    }

    /**
     * @param $routesFilePath
     */
    protected function registerRoutes($routesFilePath)
    {
        if (! $routesFilePath) {
            return;
        }

        $route = $this;

        include_once $routesFilePath;

        // Custom templates
        add_filter('theme_page_templates', function($templates) {
            foreach ($this->templates as $key => $custom) {
                $templates[$key] = $custom->getName();
            }

            return $templates;
        });

        add_filter('template_include', function ($template) {
            $originalTemplate = $template;

            if (str_contains($template, '.php')) {
                $template = explode('/', str_replace('.php', '', $template));
                $template = end($template);
            }

            if ($template != 'search' && $this->routeIsDefined($key = get_post_meta(get_the_ID(), '_wp_page_template', true))) {
                return $this->routeResponse($this->templates[$key]);
            }

            if ($this->routeIsDefined($template)) {
                return $this->routeResponse($this->routes[$template]);
            }

            return $originalTemplate;
        });
    }

    /**
     * @param $name
     * @param $endpoint
     */
    public function register($name, $endpoint)
	{
		$this->routes[$name] = new Route($name, $endpoint, $this->namespace);
	}

    /**
     * @param $key
     * @param $name
     * @param $endpoint
     */
    public function template($key, $name, $endpoint)
    {
        $this->templates[$key] = new Route($name, $endpoint, $this->namespace);
	}

    /**
     * @param $route
     *
     * @return bool
     */
    protected function routeIsDefined($route)
    {
        return isset($this->routes[$route]) or isset($this->templates[$route]);
	}

    /**
     * @param $route
     *
     * @return null
     */
    public function resolve($route)
    {
        if (isset($this->routes[$route])) {
            return $this->routes[$route]->resolve();
        }

        if (isset($this->templates[$route])) {
            return $this->templates[$route]->resolve();
        }

        return null;
	}

    /**
     * @param $route
     */
    protected function routeResponse($route)
    {
        $response = $route->resolve();

        if (is_array($response) or is_object($response)) {
            header('Content-type: JSON');
            echo json_encode($response);
            return;
        }

        echo $response;
    }
}