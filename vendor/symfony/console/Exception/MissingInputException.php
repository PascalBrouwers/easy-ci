<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace EasyCI20220522\Symfony\Component\Console\Exception;

/**
 * Represents failure to read input from stdin.
 *
 * @author Gabriel Ostrolucký <gabriel.ostrolucky@gmail.com>
 */
class MissingInputException extends \EasyCI20220522\Symfony\Component\Console\Exception\RuntimeException implements \EasyCI20220522\Symfony\Component\Console\Exception\ExceptionInterface
{
}
