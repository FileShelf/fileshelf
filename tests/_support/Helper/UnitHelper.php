<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Module;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class UnitHelper extends Module
{

    /** @var null|array */
    protected static $testEnvConfig = null;


    /**
     * Get accessible variant of a private/protected class method via Reflection
     *
     * @param string $className
     * @param string $name
     * @return ReflectionMethod
     * @throws ReflectionException
     */
    public static function getNonPublicMethod(string $className, string $name)
    {
        $class = new ReflectionClass($className);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }


    public static function getAppConfig()
    {
        if (self::$testEnvConfig === null) {
            self::$testEnvConfig = require 'config/test.php';
        }
        return self::$testEnvConfig;
    }
}
