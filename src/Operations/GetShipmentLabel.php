<?php

namespace SeniorProgramming\PostisGate\Operations;

use SeniorProgramming\PostisGate\Core\Endpoint;
use SeniorProgramming\PostisGate\Exceptions\PostisGateInvalidParamException;

class GetShipmentLabel extends Endpoint
{
    public $type = 'FILE';
    /**
     *
     * @return string
     */
    protected function getCallMethod()
    {
        return '/api/v1/clients/shipments/'.$this->shipmentId.'/label';
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
            'shipmentId' => 'required|string',
        ];
    }

    public function message()
    {
        return [
        ];
    }
}

