<?php

namespace Incognito\Requests;

class Validator
{
    protected $errors = [];

    public function validate($key, $value, $rules)
    {
        foreach (explode('|', $rules) as $rule) {
            $validator = 'validate' . ucfirst(strtolower($rule));
            if (! $this->$validator($value)) {
                $this->errors[$key] = $rule;
            }
        }
    }

    public function validateEmail($value)
    {
        return !! filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function validateRequired($value)
    {
        if (empty(trim($value))) {
            return false;
        }

        return true;
    }

    public function validateArray($value)
    {
        return is_array($value);
    }

    public function errors()
    {
        $errors = [];

        foreach ($this->errors as $key => $error) {
            $errors[$key] = config("locale.validations.{$error}");
        }

        return $errors;
    }

    public function error($key)
    {
        if (isset($this->errors[$key])) {
            return config("locale.validations.{$this->errors[$key]}");
        }
    }

    public function isValid()
    {
        return count($this->errors) == 0;
    }
}