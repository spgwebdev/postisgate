<?php

namespace SeniorProgramming\PostisGate\Core;

use Illuminate\Support\Facades\Storage;
use SeniorProgramming\PostisGate\Core\BaseInterface;
use SeniorProgramming\PostisGate\Exceptions\PostisGateInstanceException;
use SeniorProgramming\PostisGate\Exceptions\PostisGateUnknownModelException;
use SeniorProgramming\PostisGate\Exceptions\PostisGateInvalidParamException;
use \Curl\Curl;

abstract class Base implements BaseInterface {

    protected $instance;

    /**
     *
     * @param string $class
     * @return \SeniorProgramming\PostisGate\Requests\class_call
     * @throws PostisGateUnknownModelException
     */
    public function instantiate ($class)
    {
        $class_call = "SeniorProgramming\\PostisGate\\Operations\\" . $class;
        if (!class_exists($class_call)) {
            throw new PostisGateUnknownModelException("Class $class_call does not exist");
        }
        return new $class_call();
    }


    /**
     *
     * @param \SeniorProgramming\PostisGate\Requests\class_call $object
     * @return string
     * @throws PostisGateInvalidParamException
     */
    public function makeRequest($object)
    {
        if (!is_object($object) && empty($object)) {
            throw new PostisGateInvalidParamException("Invalid object");
        }

        if (!in_array($object->fetchResults(), $this->checkResultType())) {
            throw new PostisGateInvalidParamException("Invalid result type");
        }
        $url = $this->getUrl($object);
        $this->instance = $object;

        $params = (array) $object;
        if (isset($params['callMethod'])) {
            unset($params['callMethod']);
        }

        return $this->curlRequest($params, $url, $object->fetchResults(), $object->type);
    }

    /**
     *
     * @param array $data
     * @param string $url
     * @param string $resultType
     * @return string
     * @throws PostisGateInstanceException
     */
    private function curlRequest ($data, $url, $resultType, $type)
    {
        if(!empty($data['type'])){
            unset($data['type']);
        }

        $this->checkParams($data);
        $this->checkUrl($url);

        $curl = new Curl();

        $curl->setHeader('Content-Type', 'application/json;charset=UTF-8');
        $curl->setHeader('Accept', 'application/json');

        if(!empty($data['token'])) {
            $curl->setHeader('Authorization', 'Bearer '.$data['token']);
            unset($data['token']);
        }

        $curl->setOpt(CURLOPT_SSL_VERIFYHOST,0);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,0);
        if($type == 'FILE'){
            $curl->setOpt(CURLOPT_FOLLOWLOCATION,1);
        }

        switch($type){
            case 'POST': $curl->post($url, json_encode($data));
            break;
            case 'DELETE': $curl->delete($url, $data);
            break;
            default: $curl->get($url, $data);
        }

        if ($curl->error) {
            dd($data, json_encode($data), $curl->response);
            throw new PostisGateInstanceException('Invalid curl error. Code: '. $curl->errorCode . '. Message: '. $curl->errorMessage.' '.$curl->response->message);
        } else {
            if($type == 'FILE'){
                $filename = !empty($data['filename']) ? $data['filename'] : array_shift($data).'.pdf';
                Storage::disk('postisgate')->put($filename, $curl->response);
                return true;
            }
            return $this->getResultType($resultType, $curl->response);
        }
    }

    /**
     *
     * @param \SeniorProgramming\PostisGate\Requests\class_call $object
     * @return string
     * @throws PostisGateInstanceException
     */
    private function getUrl($object)
    {
        if (empty($object->callMethod)) {
            throw new PostisGateInstanceException("Unset url request");
        }

        return $object->callMethod;
    }

    /**
     *
     * @param string $url
     * @throws PostisGateInstanceException
     */
    private function checkUrl ($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new PostisGateInstanceException("Invalid url request");
        }
    }

    /**
     *
     * @param array $data
     * @throws \Exception
     */
    private function checkParams ($data)
    {

        if (!is_array($data) && empty($data)) {
            throw new \Exception("Invalid params");
        }

        if (!is_array($data) && empty($data)) {
            throw new \Exception("Invalid params");
        }
    }


    /**
     *
     * @return array
     */
    private function checkResultType ()
    {
        return ['json', 'bool', 'parse', 'token'];
    }

    /**
     *
     * @param string $type
     * @param string $result
     * @return string|bool
     */
    private function getResultType($type, $result)
    {
        switch ($type) {
            case 'json' :
                return collect($result)->toJson();
            case 'bool' :
                return is_callable([$this->instance, 'parseResult']) ? $this->instance->parseResult($result) : false;
            case 'parse' :
                return is_callable([$this->instance, 'parseResult']) ? $this->instance->parseResult($result) : $result;
            case 'token' :
                if(!empty($result->token)){
                    return $result->token;
                } else {
                    throw new PostisGateTokenInvalidException("The Token could not be obtained");
                }
            default :
                return $result;
        }
    }
}
