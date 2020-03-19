<?php

/**
 * Class Result
 *
 * просто шранилище результата парсинга
 */
class Result
{
    /** @var string $id счёт */
    private $id = null;

    /** @var string $sum сумма */
    private $sum = null;

    /** @var string $password пароль */
    private $password = null;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "Счёт: %s%sСумма: %s%sПароль: %s",
            $this->id,
            PHP_EOL,
            $this->sum,
            PHP_EOL,
            $this->password
        );
    }
}