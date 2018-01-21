<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2018. 01. 21.
 * Time: 11:43
 */

namespace facebook;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

/**
 * Class SendApi
 * @package facebook
 */
class SendApi {
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $pageToken;

    /**
     * SendApi constructor.
     * @param string $url
     * @param string $pageToken
     */
    public function __construct(string $url, string $pageToken) {
        $this->url = $url;
        $this->pageToken = $pageToken;
    }

    /**
     * @param string $recipient_id
     * @param string $message
     * @param string $imgurl
     * @return Response
     */
    public function sendMessage(string $recipient_id, string $message) {
        $client = new Client();
        $data = [
            "messaging_type" => "RESPONSE",
            "recipient" => [
                "id" => $recipient_id,
            ],
            "message" => [],
        ];
        $data["message"][] = ["text" => $message];

        $result = $client->request('POST', $this->url, [
            'query' => ['access_token' => $this->pageToken],
            'json' => $data
        ]);
        return $result;
    }
}