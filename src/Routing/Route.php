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

		add_filter("{$name}_template", function ($template) use ($name, $endpoint) {
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
