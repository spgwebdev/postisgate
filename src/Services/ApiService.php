<?php
namespace SeniorProgramming\PostisGate\Services;

use SeniorProgramming\PostisGate\Core\Base;
use SeniorProgramming\PostisGate\Exceptions\PostisGateInstanceException;
use SeniorProgramming\PostisGate\Exceptions\PostisGateInvalidParamException;
use SeniorProgramming\PostisGate\Exceptions\PostisGateUnknownModelException;

class ApiService extends Base {

    private $token;

    /**
     *
     * @throws PostisGateInvalidParamException
     */
    public function __construct() {
        if(!config('postisgate.username') || !config('postisgate.password') || !config('postisgate.api')) {
            throw new PostisGateInvalidParamException('Please set POSTISGATE_USERNAME, POSTISGATE_PASSWORD and POSTISGATE_API environment variables.');
        }

        $this->token = $this->login([
            'name'  => config('postisgate.username'),
            'password'  => config('postisgate.password'),
        ]);
    }

    /**
     *
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws PostisGateUnknownModelException
     * @throws PostisGateInstanceException
     */
    public function __call($method, $args = array()) {
        $instance = parent::instantiate(ucfirst($method));

        if(!empty($this->token)){
            $instance->token = $this->token;
        }

        if(!is_callable([$instance, 'set'])) {
            throw new PostisGateUnknownModelException("Method $method does not exist");
        }

        try {
            return parent::makeRequest(call_user_func_array([$instance, 'set'], $args));
        } catch (Exception $ex) {
            throw new PostisGateInstanceException("Invalid request");
        }
    }
}


