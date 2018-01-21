<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2018. 01. 15.
 * Time: 13:02
 */
return [
    'settings'=>[
        'displayErrorDetails'=>true,
        'addContentLengthHeader'=>false,
        'logger'=>[
            'name'=>'Ekibot',
            'path'=>'php://stderr',
            'level'=>Monolog\Logger::DEBUG,
        ],
        'verifyToken' => 'ekitoken',
        'pageToken' => getenv('pageToken'),
        'sendApi' => 'https://graph.facebook.com/v2.6/',
    ]
];