<?php

namespace app\enums;

enum TelegramCommands: string
{
    case START   = '/start';
    case HELP    = '/help';
    case STORE   = '/store';
    case DEFAULT = 'default';
}