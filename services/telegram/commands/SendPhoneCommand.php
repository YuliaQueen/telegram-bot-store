<?php

namespace app\services\telegram\commands;

use Telegram\Bot\Commands\Command;

class SendPhoneCommand extends Command
{
    protected string $name = 'sendphone';
    protected string $description = 'Send your phone number';

    public function handle()
    {
        $this->replyWithMessage([
            'text' => 'Please send your contact details so we can save your phone number.',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => 'Отправить контакт', 'request_contact' => true]
                    ],
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]),
        ]);
    }
}
