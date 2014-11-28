<?php

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Mcustiel\\', __DIR__ . '/../src');
$loader->add('Tests\\', __DIR__ . '/unit');
$loader->add('Fixtures\\', __DIR__ . '/fixtures');