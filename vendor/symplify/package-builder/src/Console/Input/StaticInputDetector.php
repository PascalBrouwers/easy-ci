<?php

declare (strict_types=1);
namespace EasyCI20220219\Symplify\PackageBuilder\Console\Input;

use EasyCI20220219\Symfony\Component\Console\Input\ArgvInput;
/**
 * @api
 */
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \EasyCI20220219\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
