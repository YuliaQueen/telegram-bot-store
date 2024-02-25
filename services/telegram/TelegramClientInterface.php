<?php

namespace app\services\telegram;

interface TelegramClientInterface
{
    public function sendMessage($id, string $string);
}