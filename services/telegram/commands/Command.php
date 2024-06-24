<?php

namespace app\services\telegram\commands;

interface Command
{
    /**
     * @param int    $chatId
     * @param string $name
     * @return void
     */
    public function execute(int $chatId, string $name, $data = null): void;
}