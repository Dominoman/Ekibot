<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2018. 01. 15.
 * Time: 12:59
 */

require __DIR__.'/../vendor/autoload.php';

session_start();

$settings=require __DIR__.'/../src/settings.php';

$app=new Slim\App($settings);

require __DIR__.'/../src/dependencies.php';

require __DIR__.'/../src/routes.php';

try {
    $app->run();
} catch (Exception $e) {
    error_log($e->getMessage());
    error_log($e->getTraceAsString());
}