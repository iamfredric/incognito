<?php

namespace Incognito\Components;

class Components
{
    /**
     * @var array
     */
    protected $components = [];

    /**
     * @var null
     */
    protected $prefix;

    /**
     * Components constructor.
     *
     * @param array $components
     * @param null $prefix
     */
    public function __construct($components = [], $prefix = null)
    {
        if ($prefix) {
            $this->prefix = ucfirst(strtolower($prefix));
        }

        $this->resolveComponents($components);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->components;
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return count($this->components) > 0;
    }

    /**
     * @param $components
     */
    protected function resolveComponents($components)
    {
        if (! $components) {
            return;
        }

        foreach ($components as $component) {
            $this->components[] = $this->initializeComponent(
                $component,
                $this->resolveClassname($component['acf_fc_layout'])
            );
        }
    }

    /**
     * @param $name
     *
     * @return string
     */
    protected function resolveClassname($name)
    {
        $name = ucfirst($name);

        if (! $this->prefix) {
            return "\\App\\Components\\{$name}Component";
        }

        return "\\App\\Components\\{$this->prefix}\\{$name}Component";
    }

    /**
     * @param $component
     * @param $classname
     *
     * @return \Incognito\Components\Component
     */
    protected function initializeComponent($component, $classname)
    {
        if (class_exists($classname)) {
            return new $classname($component, $this->prefix);
        }

        return new Component($component, $this->prefix);
    }
}
