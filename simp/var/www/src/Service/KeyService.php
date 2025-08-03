<?php

namespace App\Service;

use AllowDynamicProperties;

#[AllowDynamicProperties] class KeyService
{

    public function __construct()
    {
       $this->key = 'key';
    }

    public function getKey()
    {
        return $this->key;
    }
}