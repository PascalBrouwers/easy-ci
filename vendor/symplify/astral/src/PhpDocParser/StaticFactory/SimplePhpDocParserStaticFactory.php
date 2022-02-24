<?php

declare (strict_types=1);
namespace EasyCI20220224\Symplify\Astral\PhpDocParser\StaticFactory;

use EasyCI20220224\PHPStan\PhpDocParser\Lexer\Lexer;
use EasyCI20220224\PHPStan\PhpDocParser\Parser\ConstExprParser;
use EasyCI20220224\PHPStan\PhpDocParser\Parser\PhpDocParser;
use EasyCI20220224\PHPStan\PhpDocParser\Parser\TypeParser;
use EasyCI20220224\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
/**
 * @api
 */
final class SimplePhpDocParserStaticFactory
{
    public static function create() : \EasyCI20220224\Symplify\Astral\PhpDocParser\SimplePhpDocParser
    {
        $phpDocParser = new \EasyCI20220224\PHPStan\PhpDocParser\Parser\PhpDocParser(new \EasyCI20220224\PHPStan\PhpDocParser\Parser\TypeParser(), new \EasyCI20220224\PHPStan\PhpDocParser\Parser\ConstExprParser());
        return new \EasyCI20220224\Symplify\Astral\PhpDocParser\SimplePhpDocParser($phpDocParser, new \EasyCI20220224\PHPStan\PhpDocParser\Lexer\Lexer());
    }
}