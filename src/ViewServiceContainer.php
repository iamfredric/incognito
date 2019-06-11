<?php

namespace Incognito;

use duncan3dc\Laravel\BladeInstance;
use duncan3dc\Laravel\Directives;
use Iamfredric\Instantiator\Instantiator;

class ViewServiceContainer
{
    /**
     * @var \duncan3dc\Laravel\BladeInstance
     */
    protected $blade;

    /**
     * @var array
     */
    private $composers = [];

    /**
     * @var array
     */
    protected $directives = [];

    /**
     * ViewServiceContainer constructor.
     *
     * @param $viewsDirectory
     * @param $cacheDirecyory
     * @param array $composers
     * @param array $directives
     */
    public function __construct($viewsDirectory, $cacheDirecyory, $composers = [], $directives = [])
    {
        $this->blade = new BladeInstance(
            $viewsDirectory, $cacheDirecyory
        );

        $this->composers = $composers;
        $this->directives = $directives;

        $this->addViewComposers()
             ->addDirectives();
    }

    /**
     * Registers custom directives
     *
     * @return $this
     */
    public function addDirectives()
    {
        foreach ($this->directives as $name => $classname) {
            $this->blade->directive($name, function ($expression) use ($classname) {
                return (new Instantiator($classname))->call()->render($expression);
            });
        }

        return $this;
    }

    /**
     * Register custom view composers
     *
     * @return $this
     */
    public function addViewComposers()
    {
        foreach ($this->composers as $view => $classname) {
            $this->blade->composer($view, function ($view) use ($classname) {
                return (new Instantiator($classname))->call()->compose($view);
            });
        }

        return $this;
    }

    /**
     * @return \duncan3dc\Laravel\BladeInstance
     */
    public function getBladeInstance()
    {
        return $this->blade;
    }
}
