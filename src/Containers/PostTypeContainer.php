<?php

namespace Incognito\Containers;

class PostTypeContainer
{
    protected $types = [];

    public function __construct($routesFile)
    {
        $this->getRoutes($routesFile)
            ->registerPosttypes();
    }

    public function register($slug)
    {
        $this->types[] = $type = new PosttypeRegistrar($slug);

        return $type;
    }

    public function taxonomy()
    {
        return new TaxonomyRegistrar;
    }

    protected function getRoutes($routesFile)
    {
        $type = $this;

        include_once $routesFile;

        return $this;
    }

    protected function registerPosttypes()
    {
        foreach ($this->types as $type) {
            $type->register();

            // if has taxonomies, register these and add support!
        }

        return $this;
    }
}