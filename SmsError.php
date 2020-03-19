<?php

/**
 * Class SmsError
 *
 * Ошибка из СМС
 */
class SmsError extends Exception
{
    const INVALID_ID = 1;
    const INVALID_SUM = 2;
    const NO_ENOUGH_MONEY = 3;

    const INVALID_ID_PATTERN = '/(кошелек яндекс\.денег указан неверно)/ui';
    const INVALID_SUM_PATTERN = '/(сумма указана неверно)/ui';
    const NO_ENOUGH_MONEY_PATTERN = '/(недостаточно средств)/ui';

    const PATTERNS_TO_CODES = [
        self::INVALID_ID_PATTERN      => self::INVALID_ID,
        self::INVALID_SUM_PATTERN     => self::INVALID_SUM,
        self::NO_ENOUGH_MONEY_PATTERN => self::NO_ENOUGH_MONEY,
    ];

    private static function getMessageByCode(int $code)
    {
        $message = 'Неизвестная ошибка';

        switch ($code) {
            case self::INVALID_ID:
                $message = 'Некорректный счёт';
                break;
            case self::INVALID_SUM:
                $message = 'Некорректная сумма';
                break;
            case self::NO_ENOUGH_MONEY:
                $message = 'Недостаточно средств';
                break;
        }

        return $message;
    }

    public static function create(string $pattern): SmsError
    {
        $code = self::PATTERNS_TO_CODES[$pattern];
        return new static(static::getMessageByCode($code), $code);
    }
}