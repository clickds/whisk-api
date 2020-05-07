<?php

namespace ClickDs\WhiskApi\Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    public function setUp(): void
    {
        if (file_exists(getcwd() . '/.env')) {
            $dotenv = Dotenv::createImmutable(getcwd());
            $dotenv->load();
        }
        parent::setUp();
    }

    public function getSupportJson(string $path): string
    {
        $path = getcwd() . '/tests/Support/Json/' . $path;
        return file_get_contents($path);
    }
}
