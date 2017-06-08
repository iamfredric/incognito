<?php

namespace Incognito\Routing;

class Router
{
	protected $routes = [];

	protected $templates = [];

	protected $namespace;

    public function __construct($namespace = null)
    {
        $this->namespace = $namespace;
    }

	public function make($routesFile)
	{
		$route = $this;

		require $routesFile;

		// Custom templates
        add_filter('theme_page_templates', function($templates) {
            foreach ($this->templates as $key => $custom) {
                $templates[$key] = $custom->getName();
            }

            return $templates;
        });

		add_filter('template_include', function ($template) {

            if ($this->routeIsDefined($template)) {
		        return $this->routeResponse($this->routes[$template]);
            }

            if ($this->routeIsDefined($key = get_post_meta(get_the_ID(), '_wp_page_template', true))) {
                return $this->routeResponse($this->templates[$key]);
            }

            return $template;
		});
	}

	public function register($name, $endpoint)
	{
		$this->routes[$name] = new Route($name, $endpoint, $this->namespace);
	}

    public function template($key, $name, $endpoint)
    {
        $this->templates[$key] = new Route($name, $endpoint, $this->namespace);
	}

    protected function routeIsDefined($route)
    {
        return isset($this->routes[$route]) or isset($this->templates[$route]);
	}

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