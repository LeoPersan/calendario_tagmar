<?php

use JetBrains\PhpStorm\NoReturn;

if (!function_exists('dd')) {
    #[NoReturn] function dd(...$args): void
    {
        foreach ($args as $arg) {
            var_dump($arg);
        }
        die;
    }
}

if (!function_exists('dump')) {
    #[NoReturn] function dump(...$args): void
    {
        foreach ($args as $arg) {
            var_dump($arg);
        }
    }
}