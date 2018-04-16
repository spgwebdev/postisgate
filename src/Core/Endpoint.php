<?php

namespace SeniorProgramming\PostisGate\Core;

use Illuminate\Support\Facades\Validator;
use SeniorProgramming\PostisGate\Exceptions\PostisGateInvalidParamException;
use SeniorProgramming\PostisGate\Core\EndpointInterface;

abstract class Endpoint implements EndpointInterface {

    /**
     *
     * @param array $params
     * @return array
     * @throws PostisGateInvalidParamException
     */
    public function set($params = array())
    {
        if (!is_array($params)) {
            throw new PostisGateInvalidParamException('Require array');
        }

        $validator = Validator::make($params, $this->rules(), $this->message());
        if ($validator->fails()) {
            throw new PostisGateInvalidParamException(implode(', ', $validator->errors()->all()) ) ;
        }

        return $this->requirements($params);
    }

    /**
     *
     * @param array $params
     * @return \SeniorProgramming\PostisGate\Core\Endpoint
     */
    protected function requirements($params)
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
        $this->callMethod = $this->url() . $this->getCallMethod();

        return $this;
    }

    /*
     *
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /*
     *
     */
    public function __get($name)
    {
        return $this->$name;
    }

    private function url ()
    {
        return config('postisgate.api');
    }

    abstract public function fetchResults();

    abstract protected function getCallMethod();
}



