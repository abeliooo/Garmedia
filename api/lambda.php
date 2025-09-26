<?php

/**
 * VERCEL-PHP-LARAVEL
 *
 * This file is the single entry point for the Vercel serverless environment.
 * It prepares the Laravel application for the read-only filesystem.
 */

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    exit(0);
}

chdir(dirname(__DIR__));

$storagePath = '/tmp/storage';
$bootstrapPath = '/tmp/bootstrap';
$cachePath = $bootstrapPath . '/cache';

if (!is_dir($cachePath)) {
    mkdir($cachePath, 0755, true);
}

if (!is_dir($storagePath . '/framework/views')) {
    mkdir($storagePath . '/framework/views', 0755, true);
}
if (!is_dir($storagePath . '/framework/cache/data')) {
    mkdir($storagePath . '/framework/cache/data', 0755, true);
}
if (!is_dir($storagePath . '/framework/sessions')) {
    mkdir($storagePath . '/framework/sessions', 0755, true);
}
if (!is_dir($storagePath . '/logs')) {
    mkdir($storagePath . '/logs', 0755, true);
}

define('LARAVEL_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->useStoragePath($storagePath);
$app->useBootstrapPath($bootstrapPath);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);