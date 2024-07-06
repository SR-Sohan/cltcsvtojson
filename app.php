#!/usr/bin/env php
<?php


require __DIR__.'/vendor/autoload.php';

use App\CsvToJson;
use Symfony\Component\Console\Application;

$application = new Application();


$application->add(new CsvToJson());

$application->run();