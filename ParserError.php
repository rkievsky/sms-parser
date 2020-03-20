<?php

/**
 * Class SmsError
 *
 * Ошибка из СМС
 */
class ParserError extends Exception
{
    const INVALID_RESULT = 1;

    private static function getMessageByCode(int $code, string $additional = '')
    {
        $message = 'Неизвестная ошибка';

        switch ($code) {
            case self::INVALID_RESULT:
                $message = 'Получен не валидный результат';
                break;
        }

        return $message;
    }

    public static function create(int $code, string $additional = '', Throwable $prevError = null): ParserError
    {
        return new static(static::getMessageByCode($code, $additional), $code, $prevError);
    }
}