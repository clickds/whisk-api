<?php

namespace ClickDs\WhiskApi\Exceptions;

use Exception;

class InvalidConfigurationException extends Exception
{
    public function __toString()
    {
        return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }
}
