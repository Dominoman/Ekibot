<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2018. 01. 15.
 * Time: 13:04
 */

$container=$app->getContainer();

$container['logger']=function (\Slim\Container $c){
    $settings=$c->get('settings')['logger'];
    $logger=new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'],$settings['level']));
    return $logger;
};

$container['sendApi'] = function (\Slim\Container $c) {
    $apiURL = $c->get('settings')['sendApi'];
    $pageToken = $c->get('settings')['pageToken'];
    $sendApi = new \facebook\SendApi($apiURL, $pageToken);
    return $sendApi;
};