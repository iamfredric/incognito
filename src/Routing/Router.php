<?php

namespace Incognito\Routing;

class Router
{
	protected $routes = [];

	protected $templates = [];

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
		$this->routes[$name] = new Route($name, $endpoint);
	}

    public function template($key, $name, $endpoint)
    {
        $this->templates[$key] = new Route($name, $endpoint);
	}

    protected function routeIsDefined($route)
    {
        return isset($this->routes[$route]) or isset($this->templates[$route]);
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