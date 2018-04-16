<?php

namespace SeniorProgramming\PostisGate\Operations;

use SeniorProgramming\PostisGate\Core\Endpoint;
use SeniorProgramming\PostisGate\Exceptions\PostisGateInvalidParamException;

class TraceShipmentsByAwbList extends Endpoint
{
    public $type = 'GET';
    /**
     *
     * @return string
     */
    protected function getCallMethod()
    {
        return 'GET /api/v1/clients/shipments/trace';
    }

    /**
     *
     * @return string
     */
    public function fetchResults()
    {
        return 'json';
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
            'name' => 'required',
            'type' => 'nullable|string',
        ];
    }

    public function message()
    {
        return [
        ];
    }
}

