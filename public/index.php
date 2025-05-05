<?php

if ((! ($_SERVER['FRANKENPHP_WORKER'] ?? false)) || ! function_exists('frankenphp_handle_request')) {
    echo 'FrankenPHP must be in worker mode to use this script.';
    exit(1);
}

require __DIR__.'/../vendor/autoload.php';

require __DIR__.'/../vendor/laravel/octane/bin/frankenphp-worker.php';
