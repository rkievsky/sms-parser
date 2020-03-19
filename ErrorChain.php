<?php

class ErrorChain extends TextChain
{
    /**
     * Если в тексте найдено искомое значение вернёт выражени, которое выполняло поиск
     *
     * @param $text
     * @return string|null
     */
    protected function getValue($text): ?string
    {
        $matches = [];
        preg_match($this->regExp, $text, $matches);

        // Так как все регулярки написаны так, что в них есть только 1 группа,
        // то нужный результат будет всегда в элементе с индексом 1
        // Но вернём мы не результат, а выражение, которое его нашло, чтобы по-проще было установить код ошибки
        return empty($matches[1]) ? null : $this->regExp;
    }
}