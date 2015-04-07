<?php

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Europe/Prague');
Tester\Environment::setup();

// create temporary directory
define('TEMP_DIR', __DIR__ . '/temp/' . getmypid());
@mkdir(dirname(TEMP_DIR)); // @ - directory may already exist
Tester\Helpers::purge(TEMP_DIR);


if (getenv(Tester\Environment::RUNNER)) {
	# Runner
	header('Content-type: text/plain');
	putenv('ANSICON=TRUE');

} elseif (PHP_SAPI === 'cli') {
	# CLI

} else {
	# Browser
}
