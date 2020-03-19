<?php
/**
 * Created by PhpStorm.
 * User: roma
 * Date: 06.09.18
 * Time: 18:04
 */

/**
 * Interface ChainOfResponsibility
 */
interface ChainOfResponsibilityInterface
{
    /**
     * Реализация паттерна "Цепочка вызовов".
     * Метод задаёт следующее звено цепочки.
     *
     * @param ChainOfResponsibilityInterface $finder
     * @return ChainOfResponsibilityInterface
     */
    public function setNext(ChainOfResponsibilityInterface $chain): ChainOfResponsibilityInterface;

    /**
     * Реализация паттерна "Цепочка вызовов".
     * Метод вызывает обработку текущим звеном цепочки, если обработка успешна - цепочка завершается,
     * иначе обращаемся к следующему звену цепочки.
     * В качестве обработчика используется метод, с названием, переданнм через ппраметр
     *
     * @return string Вернёт в случае успеха найденное значение, иначе null
     */
    public function handle(string $text): ?string;

    /**
     * Не позволять переходить у следующему звену в случае успеха
     *
     * @return ChainOfResponsibilityInterface
     */
    public function setSuccessBreakPoint(): ChainOfResponsibilityInterface;

    /**
     * Не позволять переходить у следующему звену в случае неудачи
     *
     * @return ChainOfResponsibilityInterface
     */
    public function setFailBreakPoint(): ChainOfResponsibilityInterface;

    /**
     * Проверяет, надо ли прервать цепочку
     *
     * @return bool
     */
    public function isBreakPoint(): bool;
}