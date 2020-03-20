<?php

/* просто и быстро обеспечим процесс необходимыми классами */
require "SmsError.php";
require "ParserError.php";
require "ChainOfResponsibilityInterface.php";
require "TextChain.php";
require "ErrorChain.php";
require "Result.php";
require "Parser.php";



$text = &$argv[1]; // не будем лишний раз копировать
$parser = new Parser();

try {
    echo(sprintf('%s%s', (string) $parser->parse($text), PHP_EOL));
} catch (SmsError $error) {
    // была смс с ошибкой. В исключении для каждого типа ошибки свой код - можно предпринять что-то особенное в каждом случае
    echo(sprintf('%s%s', $error->getMessage(), PHP_EOL));
} catch (ParserError $error) {
    // Не получилось распарсить СМС
    echo(sprintf('%s. Сообщение: "%s"%s', $error->getMessage(), $text, PHP_EOL));
}
