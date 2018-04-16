<?php

namespace SeniorProgramming\PostisGate\Core;

interface BaseInterface {

    public function instantiate ($class);

    public function makeRequest($object);
}
