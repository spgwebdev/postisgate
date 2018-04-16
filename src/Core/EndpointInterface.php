<?php

namespace SeniorProgramming\PostisGate\Core;

interface EndpointInterface {

    public function set($params);

    public function fetchResults();

    public function rules();

    public function message();
}

