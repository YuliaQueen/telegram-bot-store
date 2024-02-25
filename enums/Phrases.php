<?php

namespace app\enums;

enum Phrases: string
{
    case Start          = 'Hello, %s!';
    case InlineKeyboard = 'Button for open store';
    case BtnSubscribe   = 'Подписаться на скидки и акции';
    case InputField     = 'Нажми на кнопку';
    case BtnUnsubscribe = 'Отписаться';
    case BtnOpenStore   = 'Открыть магазин';
    case BtnClose       = 'Закрыть';
}