<?php

/**
 * Class Parser
 *
 * Парсер
 */
class Parser
{
    /** @var ChainOfResponsibilityInterface $idChain цепочка для поиска номера счёта */
    private $idChain = null;

    /** @var ChainOfResponsibilityInterface $sumChain цепочка для поиска суммы */
    private $sumChain = null;

    /** @var ChainOfResponsibilityInterface $passwordChain цепочка для поиска пароля */
    private $passwordChain = null;

    /** @var ChainOfResponsibilityInterface $errorsChain цепочка для поиска ошибок */
    private $errorsChain = null;

    /**
     * Инициализация цепочки поиска номера счёта
     */
    private function setIdChain() : void
    {
        $this->idChain = new TextChain('/перевод на счет[\s\D\W]+([0-9]{13})/ui');
    }

    /**
     * Инициализация цепочки поиска суммы
     */
    private function setSumChain() : void
    {
        $this->sumChain = new TextChain('/спишется[\s\D\W]+([0-9]+)р/ui'); // сумма без копеек
        $this->sumChain->setSuccessBreakPoint()
            ->setNext(new TextChain('/спишется[\s\D\W]+([0-9]+\,[0-9]+)р/ui'));  // сумма с копейками
    }

    /**
     * Инициализация цепочки поиска пароля
     */
    private function setPasswordChain() : void
    {
        $this->passwordChain = new TextChain('/пароль: \b([\d]+)\b/ui');
    }

    /**
     * Инициализация цепочки поиска ошибок
     */
    private function setErrorsChain() : void
    {
        $this->errorsChain = new ErrorChain(SmsError::INVALID_ID_PATTERN);
        $this->errorsChain->setSuccessBreakPoint()
            ->setNext(new ErrorChain(SmsError::INVALID_SUM_PATTERN))
            ->setSuccessBreakPoint()
            ->setNext(new ErrorChain(SmsError::NO_ENOUGH_MONEY_PATTERN));
    }

    /**
     * Parser constructor.
     *
     * Инициализирует цепочки
     */
    public function __construct()
    {
        $this->setIdChain();
        $this->setSumChain();
        $this->setPasswordChain();
        $this->setErrorsChain();
    }

    /**
     * Парсит текст, если в смске текст ошибки - будет исключение с кодом соответствующей ошибки
     *
     * @param string $text
     * @return Result
     * @throws SmsError
     */
    public function parse(string $text) : Result
    {
        $result = new Result();
        $result->setId($this->idChain->handle($text));
        $result->setSum($this->sumChain->handle($text));
        $result->setPassword($this->passwordChain->handle($text));

        if ($error = $this->errorsChain->handle($text)) {
            throw SmsError::create($error);
        }

        return $result;
    }
}