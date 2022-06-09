<?php

declare (strict_types=1);
namespace EasyCI20220609;

use EasyCI20220609\PhpParser\ConstExprEvaluator;
use EasyCI20220609\PhpParser\NodeFinder;
use EasyCI20220609\PHPStan\PhpDocParser\Lexer\Lexer;
use EasyCI20220609\PHPStan\PhpDocParser\Parser\ConstExprParser;
use EasyCI20220609\PHPStan\PhpDocParser\Parser\PhpDocParser;
use EasyCI20220609\PHPStan\PhpDocParser\Parser\TypeParser;
use EasyCI20220609\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use EasyCI20220609\Symplify\Astral\PhpParser\SmartPhpParser;
use EasyCI20220609\Symplify\Astral\PhpParser\SmartPhpParserFactory;
use EasyCI20220609\Symplify\PackageBuilder\Php\TypeChecker;
use function EasyCI20220609\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public();
    $services->load('EasyCI20220609\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/NodeVisitor', __DIR__ . '/../src/PhpParser/SmartPhpParser.php', __DIR__ . '/../src/PhpDocParser/PhpDocNodeVisitor/CallablePhpDocNodeVisitor.php']);
    $services->set(SmartPhpParser::class)->factory([service(SmartPhpParserFactory::class), 'create']);
    $services->set(ConstExprEvaluator::class);
    $services->set(TypeChecker::class);
    $services->set(NodeFinder::class);
    // phpdoc parser
    $services->set(PhpDocParser::class);
    $services->set(Lexer::class);
    $services->set(TypeParser::class);
    $services->set(ConstExprParser::class);
};
