<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2018. 01. 15.
 * Time: 13:04
 */

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Dummy get
 */
$app->get('/',function (Request $request,Response $response,array$args){
    $this->logger->addDebug("Hello debug!");
    return $response->getBody()->write("Hello");
});

/**
 * Subscription
 */
$app->get('/ekibot', function (Request $request, Response $response, array $args) {
    $params=$request->getQueryParams();
    $verifyToken = $this->get('settings')['verifyToken'];
    if ($params["hub_mode"] == "subscribe" && isset($params["hub_challenge"])) {
        if ($params["hub_verify_token"] != $verifyToken) {
            return $response->withStatus(403)->getBody()->write("Verification token mismatch");
        }
        return $response->withStatus(200)->getBody()->write($params["hub_challenge"]);
    }
    return $response->withStatus(200)->getBody()->write("Hello word");
});

/**
 * get message
 */
$app->post('/ekibot', function (Request $request, Response $response, array $args) {
    $json = $request->getBody();
    $data = json_decode($json, true);
    $this->logger->addDebug(print_r($data, true));
});