<?php

namespace app\services\telegram;

interface TelegramClientInterface
{
    public function sendMessage(array $config): void;
}