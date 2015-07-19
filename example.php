<?php
/**
 * Created by PhpStorm.
 * User: roobre
 * Date: 7/19/15
 * Time: 4:27 AM
 */

require_once 'TelegramBotApi.class.php';

$bot = new \TelegramBotApi\TelegramBotApi('TOKEN');

var_dump($bot->getMe());
