<?php

namespace Incognito\Views;

use Illuminate\View\View;

class ViewComposerResolver
{
    protected $callable;

    /**
     * @var null
     */
    protected $namespace;

    public function __construct($callable, $namespace = null)
    {
        $this->callable = $callable;
        $this->namespace = $namespace;
    }

    public function resolve(View $view)
    {
        // Todo...
    }
}