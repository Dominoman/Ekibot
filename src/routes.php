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
$app->get('/', function (Request $request, Response $response, array $args) {
    return $response->getBody()->write("Hello Robot");
});

/**
 * Privacy
 */
$app->get('/privacy', function (Request $request, Response $response, array $args) {
    $privacy = $this->get('settings')['privacy'];
    return $response->getBody()->write(nl2br(file_get_contents(__DIR__ . '/../' . $privacy)));
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

    if ($data['object'] == 'page') {
        foreach ($data['entry'] as $entry) {
            foreach ($entry['messaging'] as $messaging_event) {
                if (isset($messaging_event['message'])) {
                    $senderID = $messaging_event["sender"]["id"];
                    $recipient_id = $messaging_event["recipient"]["id"];
                    $message_text = $messaging_event["message"]["text"];
                    $this->logger->addDebug("$senderID $recipient_id $message_text");

                    //$uID = $this->sendApi->getID($senderID);
                    //$this->logger->addDebug(print_r($uID, true));

                    $imgurl = "https://" . $_SERVER["SERVER_NAME"] . "/images/" . $this->ai->parse($message_text);

                    /** @var \GuzzleHttp\Psr7\Response $result */
                    $result = $this->sendApi->sendMessage($senderID, null, $imgurl);
                    if ($result->getStatusCode() != 200) {
                        $this->logger->addDebug("Error:" . $result->getStatusCode() . " " . $result->getBody());
                    }
                }
            }
        }
    }
    return $response->withStatus(200)->getBody()->write("ok");
});