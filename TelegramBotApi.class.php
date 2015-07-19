<?php
/**
 * Created by PhpStorm.
 * User: roobre
 * Date: 7/19/15
 * Time: 4:02 AM
 */

namespace TelegramBotApi;


class TelegramBotApi {
    const API_URL = 'https://api.telegram.org/bot';

    private static $methods = array(
        'getMe',
        'sendMessage',
        'forwardMessage',
        'sendPhoto',
        'sendAudio',
        'sendDocument',
        'sendSticker',
        'sendVideo',
        'sendLocation',
        'sendChatAction',
        'getUserProfilePhotos',
        'getUpdates',
        'setWebhook'
    );

    private $useCurl = false;
    private $methodCheck = true;

    private $token = null;

    public function __construct($token) {
        if (!is_string($token) || strpos($token, ':') === false || strpos($token, '-') === false) {
            throw new \Exception("The provided token does not look valid.");
        }

        $this->token = $token;
    }

    public function useCurl($bool = true) {
        $this->useCurl = $bool;
    }

    public function checkMethods($bool = true) {
        $this->methodCheck = $bool;
    }


    public function __call($name, $args = array()) {
        if ($this->methodCheck && !in_array($name, static::$methods)) {
            throw new \Exception("The specified method '$name' is not a valid Telegram endpoint.");
        }

        return $this->request($name, $args ? $args[0] : null);
    }


    private function request($endpoint, $params = null) {
        $requestOptions = array();

        if ($params) {
            $requestOptions['http']['method'] = 'POST';
            $requestOptions['http']['content'] = json_encode($params);
        } else {
            $requestOptions['http']['method'] = 'GET';
        }

        return json_decode(file_get_contents(static::API_URL . $this->token . '/' . $endpoint, false, stream_context_create($requestOptions)));
    }
}