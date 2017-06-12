<?php

namespace Incognito\Views;

use duncan3dc\Laravel\BladeInstance;
use Iamfredric\Instantiator\Instantiator;
use Incognito\ClassMethodStrings;

class BladeViewContainer
{
    use ClassMethodStrings;

    /**
     * @var \duncan3dc\Laravel\BladeInstance
     */
    protected $blade;

    /**
     * @var string
     */
    protected $composerNamespace = 'App\\Http\\ViewComposers';

    /**
     * @var string
     */
    protected $directivesNamespace = 'App\\Http\\ViewDirectives';

    /**
     * BladeViewContainer constructor.
     *
     * @param null $viewsDirectory
     * @param null $cacheDirecyory
     * @param \duncan3dc\Laravel\BladeInstance|null $blade
     * @param null $composerNamespace
     * @param null $directivesNamespace
     */
    public function __construct($viewsDirectory = null, $cacheDirecyory = null, BladeInstance $blade = null, $composerNamespace = null, $directivesNamespace = null)
    {
        $this->blade = $blade ?: new BladeInstance(
            $viewsDirectory, $cacheDirecyory
        );

        if ($composerNamespace) {
            $this->composerNamespace = $composerNamespace;
        }

        if ($directivesNamespace) {
            $this->directivesNamespace = $directivesNamespace;
        }
    }

    /**
     * @param $key
     * @param $handler
     *
     * @return $this
     */
    public function composer($key, $handler)
    {
        if (is_callable($handler)) {
            $this->getInstance()->composer($key, $handler);

            return $this;
        }

        if ($this->isClassMethodString($handler)) {
            $this->getInstance()->composer($key, function ($view) use ($handler) {
                $instantiator = new Instantiator($this->extractClassName($handler, $this->composerNamespace));
                $class = $instantiator->call();

                return $class->{$this->extractMethodName($handler)}($view);
            });

            return $this;
        }
    }

    /**
     * @param $key
     * @param $handler
     *
     * @return $this
     */
    public function directive($key, $handler)
    {
        if (is_callable($handler)) {
            $this->getInstance()->directive($key, $handler);

            return $this;
        }

        if ($this->isClassMethodString($handler)) {
            $this->getInstance()->directive($key, function ($value) use ($handler) {
                $instantiator = new Instantiator($this->extractClassName($handler, $this->directivesNamespace));
                $class = $instantiator->call();

                return $class->{$this->extractMethodName($handler)}($value);
            });

            return $this;
        }
    }

    /**
     * @return \duncan3dc\Laravel\BladeInstance
     */
    public function getInstance()
    {
        return $this->blade;
    }
}