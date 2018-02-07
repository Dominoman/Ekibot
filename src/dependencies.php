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
    $logger = $c->get('logger');
    $apiURL = $c->get('settings')['sendApi'];
    $pageToken = $c->get('settings')['pageToken'];
    $sendApi = new \facebook\SendApi($apiURL, $pageToken, $logger);
    return $sendApi;
};

$container['ai'] = function (\Slim\Container $c) {
    $datafile = $c->get('settings')['data'];
    $ai = new \facebook\StupidAI(__DIR__ . '/../' . $datafile);
    return $ai;
};

$container['db'] = function (\Slim\Container $c) {
    $dbpath = parse_url($c->get('settings')['databaseUrl']);
    $db = new \Medoo\Medoo(array(
        'database_type' => 'pgsql',
        'database_name' => ltrim($dbpath['path'], '/'),
        'server' => $dbpath['host'],
        'username' => $dbpath['user'],
        'password' => $dbpath['pass'],
        'port' => $dbpath['port'],
        'logging' => true
    ));
    return $db;
};