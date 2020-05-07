<?php

namespace ClickDs\WhiskApi\Tests\Exceptions;

use ClickDs\WhiskApi\Exceptions\InvalidConfigurationException;
use PHPUnit\Framework\TestCase;

class InvalidConfigurationExceptionTest extends TestCase
{
    public function test_to_string()
    {
        $exception = new InvalidConfigurationException('whoops', 312);

        $result = $exception->__toString();

        $expected = InvalidConfigurationException::class.": [{$exception->getCode()}]: {$exception->getMessage()}\n";
        $this->assertEquals($expected, $result);
    }
}
