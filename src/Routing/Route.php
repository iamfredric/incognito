<?php

namespace Incognito\Routing;

use Iamfredric\Instantiator\Instantiator;

class Route
{
    /**
     * Route name
     *
     * @var string
     */
    protected $name;

    /**
     * Route endpoint
     *
     * @var string
     */
    protected $endpoint;

    /**
     * Route namespace
     *
     * @var null|string
     */
    protected $namespace;

    /**
     * Route constructor.
     *
     * @param $name
     * @param $endpoint
     * @param null $namespace
     */
    public function __construct($name, $endpoint, $namespace = null)
    {
        $this->namespace = $namespace;

        $names = explode(':', $name);
        $hook = $names[0];
        $type = isset($names[1]) ? $names[1] : null;

        add_filter("{$hook}_template", function ($template) use ($name, $endpoint, $type) {
            if ($type) {
                $queriedObject = get_queried_object();

                if ($queriedObject instanceof \WP_Post_Type) {
                    $queryString = $queriedObject->name;
                }

                if ($queriedObject instanceof \WP_Term) {
                    $queryString = $queriedObject->taxonomy;
                }

                if ($queriedObject instanceof \WP_Post) {
                    $queryString = $queriedObject->slug;
                }

                if ($type == $queryString) {
                    return $name;
                }

                return $template;
            }

            return $name;
        });

        $this->name = $name;
        $this->endpoint = $endpoint;
    }

    /**
     * Getter for the full path class name
     *
     * @return string
     */
    public function getClassName()
    {
        $parts = explode('@', $this->endpoint);

        $classname = $parts[0];

        if ($this->namespace) {
            return "{$this->namespace}\\{$classname}";
        }

        return $classname;
	}

    /**
     * Getter for the method name
     *
     * @return string
     */
    public function getMethodName()
    {
        $parts = explode('@', $this->endpoint);

        return $parts[1];
	}

    /**
     * Resolves the class method
     *
     * @return mixed
     */
    public function resolve()
    {
        return (new Instantiator($this->getClassName()))
            ->callMethod($this->getMethodName());
	}

    /**
     * Getter for route name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
	}
}
