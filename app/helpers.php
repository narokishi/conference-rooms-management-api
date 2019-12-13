<?php

namespace App;

if (!function_exists('App/env')) {
    /**
     * @param string $variableName
     *
     * @return string
     */
    function env(string $variableName): string
    {
        if (!array_key_exists($variableName, $_ENV)) {
            throw new \InvalidArgumentException(
                "Given environment variable \"$variableName\" is not set in the application environment."
            );
        }

        return $_ENV[$variableName];
    }
}

if (!function_exists('App/route')) {
    /**
     * @param string $className
     * @param string|null $methodName
     *
     * @return string
     */
    function route(string $className, ?string $methodName = null): string
    {
        if (!empty($methodName)) {
            return $className . ':' . $methodName;
        }

        return $className;
    }
}

if (!function_exists('App/getCookie')) {
    /**
     * @param string $cookie
     *
     * @return string|null
     */
    function getCookie(string $cookie): ?string
    {
        return array_key_exists($cookie, $_COOKIE)
            ? $_COOKIE[$cookie] : null;
    }
}
