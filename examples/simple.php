<?php

include __DIR__ . "/../vendor/autoload.php";

$username = "user";
$password = "pass";

(new \Mnohosten\HttpAuth($username, $password))
    ->setMessage('Sorry, this area is protected.')
    ->protect();

echo "You've reached protected zone." . PHP_EOL;

