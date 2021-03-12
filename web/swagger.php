<?php
require dirname(__DIR__).'/vendor/autoload.php';

$openapi = \OpenApi\scan(dirname(__DIR__).'/controllers');
header('Content-Type: application/json');
echo $openapi->toJson();
