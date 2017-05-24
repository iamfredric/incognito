<?php

namespace Incognito;

use duncan3dc\Laravel\BladeInstance;
use Iamfredric\Instantiator\Instantiator;

class ViewServiceContainer
{
    protected $blade;

    protected $directives = [];

    /**
     * @var array
     */
    private $composers = [];

    public function __construct($viewsDirectory, $cacheDirecyory, $composers = [], $directives = [])
    {
        $this->blade = new BladeInstance(
            $viewsDirectory, $cacheDirecyory
        );

        $this->directives = $directives;
        $this->composers = $composers;

        $this->addViewComposers();
        $this->addDirectives();
        // Composers
        // $view->composer('', '');
        // Directives
        // $view->directive('', '');
    }

    public function addDirectives()
    {
        foreach ($this->directives as $name => $handler) {
            $this->blade->directive($name, $handler);
        }
    }

    public function addViewComposers()
    {
        foreach ($this->composers as $view => $composer) {
            $this->blade->composer($view, function ($view) use ($composer) {
                $parts = explode('@', $composer);
                $classname = 'App\\Http\\Composers\\' . $parts[0];

                $response = (new Instantiator($classname))->call();

                return $response->{$parts[1]}($view);
            });
        }
    }

    public function getBladeInstance()
    {
        return $this->blade;
    }
}