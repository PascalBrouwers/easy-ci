<?php

declare (strict_types=1);
namespace EasyCI202209\Symplify\PackageBuilder\Console\Input;

use EasyCI202209\Symfony\Component\Console\Input\ArgvInput;
/**
 * @api
 */
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
