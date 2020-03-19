<?php

/**
 * Class Chain
 *
 * Звено цепочки парсинга
 */
class TextChain implements ChainOfResponsibilityInterface
{
    /** @var string $regExp выражение, которое должно выполнить звено */
    protected $regExp = null;

    /** @var ChainOfResponsibilityInterface $nextChain ссылка на следующее звено цепи */
    private $nextChain = null;

    /** @var bool $needBreakOnSuccess признак того, что при успехе, надо прервать цепочку */
    private $needBreakOnSuccess = null;

    /** @var bool $needBreakOnFail признак того, что при неудаче, надо прервать цепочку */
    private $needBreakOnFail = null;

    /** @var bool $success признак удачной обработки */
    private $success = false;

    /**
     * Выгрызает из текста искомое значение
     *
     * @param $text
     * @return string|null
     */
    protected function getValue($text): ?string
    {
        $matches = [];
        preg_match($this->regExp, $text, $matches);

        // так как все регулярки написаны так, что в них есть только 1 группа,
        // то нужный результат будет всегда в элементе с индексом 1
        return $matches[1] ?? null;
    }

    /**
     * Chain constructor.
     *
     * @param string $regExp
     */
    public function __construct($regExp)
    {
        $this->regExp = $regExp;
    }

    /**
     * @inheritDoc
     */
    public function setNext(ChainOfResponsibilityInterface $chain): ChainOfResponsibilityInterface
    {
        $this->nextChain = $chain;

        return $this->nextChain;
    }

    /**
     * @inheritDoc
     */
    public function handle(string $text): ?string
    {
        $this->success = false;

        $result = $this->getValue($text);

        $this->success = (bool)$result;

        if (!$this->isBreakPoint() && $this->nextChain) {
            return $this->nextChain->handle($text);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function setSuccessBreakPoint(): ChainOfResponsibilityInterface
    {
        $this->needBreakOnSuccess = true;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setFailBreakPoint(): ChainOfResponsibilityInterface
    {
        $this->needBreakOnFail = true;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isBreakPoint(): bool
    {
        return ($this->success && $this->needBreakOnSuccess)
            || (!$this->success && $this->needBreakOnFail);
    }
}