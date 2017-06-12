<?php

namespace Incognito;

trait ClassMethodStrings
{
    public function isClassMethodString($string)
    {
        return preg_match('/([a-z]@[a-z])/i', $string);
    }

    public function extractClassName($string, $namespace = null)
    {
        $parts = explode('@', $string);

        $classname = $parts[0];

        if ($namespace) {
            return "{$namespace}\\{$classname}";
        }

        return $classname;
    }

    public function extractMethodName($string)
    {
        $parts = explode('@', $this->endpoint);

        return $parts[1];
    }
}