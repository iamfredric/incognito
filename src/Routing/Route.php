<?php

namespace Incognito\Routing;

use Iamfredric\Instantiator\Instantiator;

class Route
{
    protected $name;

    protected $endpoint;

    public function __construct($name, $endpoint)
	{
		add_filter("{$name}_template", function ($template) use ($name, $endpoint) {
			return $name;
		});

        $this->name = $name;
        $this->endpoint = $endpoint;
    }

    public function getClassName()
    {
        $parts = explode('@', $this->endpoint);

        return 'App\\Http\\Controllers\\' . $parts[0];
	}

    public function getMethodName()
    {
        $parts = explode('@', $this->endpoint);

        return $parts[1];
	}

    public function resolve()
    {
        return (new Instantiator($this->getClassName()))
            ->callMethod($this->getMethodName());
	}

    public function getName()
    {
        return $this->name;
	}
}
