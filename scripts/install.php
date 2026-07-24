<?php

declare(strict_types=1);

$root = dirname(__DIR__);
chdir($root);

$command = 'composer install --no-interaction --prefer-dist --no-progress';
$maxAttempts = 5;
$installedPhp = $root . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'installed.php';

for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
    $output = [];
    $exitCode = 0;

    exec($command . ' 2>&1', $output, $exitCode);

    if ($exitCode === 0) {
        exit(0);
    }

    $message = implode(PHP_EOL, $output);
    fwrite(STDOUT, $message . PHP_EOL);

    $isLockError = preg_match('/Resource temporarily unavailable|installed\.php/i', $message) === 1;

    if (! $isLockError || $attempt === $maxAttempts) {
        fwrite(STDERR, "Composer install failed after {$attempt} attempt(s)." . PHP_EOL);
        exit($exitCode ?: 1);
    }

    if (is_file($installedPhp)) {
        @unlink($installedPhp);
    }

    fwrite(STDOUT, "Temporary lock detected on vendor/composer/installed.php. Retrying in 2 seconds..." . PHP_EOL);
    sleep(2);
}
