<?php

namespace App;

if (!function_exists('App/env')) {
    /**
     * @param string $variableName
     *
     * @return mixed
     */
    function env(string $variableName)
    {
        if (!array_key_exists($variableName, $_ENV)) {
            throw new \InvalidArgumentException(
                "Given environment variable \"$variableName\" is not set in the application environment."
            );
        }

        return $_ENV[$variableName];
    }
}
