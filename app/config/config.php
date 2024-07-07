<?php

$env = parse_ini_file(realpath(__DIR__ . '/../../.env'));

define('URL', '/');
define('UPLOAD_MAX_SIZE', 1000000);
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('UPLOAD_DIR', dirname(__DIR__, 2) . '/app/uploads');

define('SECRET_KEY', $env['SECRET_KEY']);
define('DB_HOST', $env['DB_HOST']);
define('DB_NAME', $env['DB_NAME']);
define('DB_USER', $env['DB_USER']);
define('DB_PASSWORD', $env['DB_PASSWORD']);
