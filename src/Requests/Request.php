<?php

namespace Incognito\Requests;

class Request
{
    protected $body = [];

    protected $headers = [];

    protected $rules = null;

    protected $validator;

    public function __construct(Validator $validator = null)
    {
        $this->validator = $validator ?: new Validator();
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function get($key)
    {
        if (isset($this->body[$key])) {
            return $this->body[$key];
        }

        if (isset($_POST[$key])) {
            return $_POST[$key];
        }

        if (isset($_GET[$key])) {
            return $_GET[$key];
        }
    }

    public function validate()
    {
        foreach ((array) $this->rules as $key => $rules) {
            $this->validator->validate($key, $this->get($key), $rules);
        }

        return $this;
    }

    public function response()
    {
        if ($this->validator->isValid()) {
            return [
                'status' => 200,
                'message' => 'ok',
                'body' => $this->afterValidationComplete()
            ];
        }

        return [
            'status' => 422,
            'message' => 'Validation failed',
            'body' => $this->validator->errors()
        ];
    }

    protected function afterValidationComplete()
    {}
}