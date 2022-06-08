<?php

declare (strict_types=1);
namespace EasyCI20220608\Symplify\PackageBuilder\Console\Input;

use EasyCI20220608\Symfony\Component\Console\Input\ArgvInput;
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
