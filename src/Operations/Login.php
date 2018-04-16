<?php

namespace SeniorProgramming\PostisGate\Operations;

use SeniorProgramming\PostisGate\Core\Endpoint;
use SeniorProgramming\PostisGate\Exceptions\PostisGateInvalidParamException;

class Login extends Endpoint
{
    public $type = 'POST';
    /**
     *
     * @return string
     */
    protected function getCallMethod()
    {
        return '/unauthenticated/login';
    }

    /**
     *
     * @return string
     */
    public function fetchResults()
    {
        return 'token';
    }

    /**
     *
     * @param array $params
     * @return boolean
     * @throws PostisGateInvalidParamException
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'password' => 'required|string'
        ];
    }

    public function message()
    {
        return [
            'name.required' => 'The name is required',
            'password.required' => 'The password is required'
        ];
    }
}

