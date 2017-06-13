<?php

namespace Incognito\Routing;

use Iamfredric\Instantiator\Instantiator;
use Incognito\ClassMethodStrings;

class ApiRoute
{
    use ClassMethodStrings;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var null|string
     */
    protected $namespace;

    /**
     * @var null|string
     */
    protected $apiNamespace;

    /**
     * ApiRoute constructor.
     *
     * @param $method
     * @param $uri
     * @param $endpoint
     * @param null $namespace
     * @param null $apiNamespace
     */
    public function __construct($method, $uri, $endpoint, $namespace = null, $apiNamespace = null)
    {
        $this->method = strtoupper($method);
        $this->uri = preg_replace("/{([a-z]+)}/", '(?P<$1>\w+)', $uri);
        $this->endpoint = $endpoint;
        $this->namespace = $namespace;
        $this->apiNamespace = $apiNamespace;
    }

    /**
     * @throws \Exception
     */
    public function register()
    {
        $registrationWasSuccessfull = register_rest_route($this->apiNamespace, $this->uri, [
            'methods' => $this->method,
            'callback' => function ($data) {
                $class = new Instantiator($this->extractClassName($this->endpoint, $this->namespace));

                return $class->{$this->extractMethodName($this->endpoint)}($data);
            }
        ]);

        if (! $registrationWasSuccessfull) {
            throw new \Exception("Could not register route {$this->uri}");
        }
    }
}