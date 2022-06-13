<?php

declare (strict_types=1);
namespace EasyCI202206\Symplify\Astral\Reflection;

use EasyCI202206\PhpParser\Node;
use EasyCI202206\PhpParser\Node\Stmt\ClassLike;
use EasyCI202206\PhpParser\Node\Stmt\ClassMethod;
use EasyCI202206\PhpParser\Node\Stmt\Property;
use EasyCI202206\PhpParser\NodeFinder;
use EasyCI202206\PHPStan\Reflection\ClassReflection;
use EasyCI202206\PHPStan\Reflection\MethodReflection;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use EasyCI202206\Symplify\Astral\PhpParser\SmartPhpParser;
use Throwable;
/**
 * @api
 */
final class ReflectionParser
{
    /**
     * @var array<string, ClassLike>
     */
    private $classesByFilename = [];
    /**
     * @var \Symplify\Astral\PhpParser\SmartPhpParser
     */
    private $smartPhpParser;
    /**
     * @var \PhpParser\NodeFinder
     */
    private $nodeFinder;
    public function __construct(SmartPhpParser $smartPhpParser, NodeFinder $nodeFinder)
    {
        $this->smartPhpParser = $smartPhpParser;
        $this->nodeFinder = $nodeFinder;
    }
    public function parsePHPStanMethodReflection(MethodReflection $methodReflection) : ?ClassMethod
    {
        $classReflection = $methodReflection->getDeclaringClass();
        $fileName = $classReflection->getFileName();
        if ($fileName === null) {
            return null;
        }
        $class = $this->parseFilenameToClass($fileName);
        if (!$class instanceof Node) {
            return null;
        }
        return $class->getMethod($methodReflection->getName());
    }
    /**
     * @param \ReflectionMethod|\PHPStan\Reflection\MethodReflection $reflectionMethod
     */
    public function parseMethodReflection($reflectionMethod) : ?ClassMethod
    {
        $classLike = $this->parseNativeClassReflection($reflectionMethod->getDeclaringClass());
        if (!$classLike instanceof ClassLike) {
            return null;
        }
        return $classLike->getMethod($reflectionMethod->getName());
    }
    public function parsePropertyReflection(ReflectionProperty $reflectionProperty) : ?Property
    {
        $class = $this->parseNativeClassReflection($reflectionProperty->getDeclaringClass());
        if (!$class instanceof ClassLike) {
            return null;
        }
        return $class->getProperty($reflectionProperty->getName());
    }
    public function parseClassReflection(ClassReflection $classReflection) : ?ClassLike
    {
        $filename = $classReflection->getFileName();
        if ($filename === null) {
            return null;
        }
        return $this->parseFilenameToClass($filename);
    }
    /**
     * @param \ReflectionClass|\PHPStan\Reflection\ClassReflection $reflectionClass
     */
    private function parseNativeClassReflection($reflectionClass) : ?ClassLike
    {
        $fileName = $reflectionClass->getFileName();
        if ($fileName === \false) {
            return null;
        }
        if ($fileName === null) {
            return null;
        }
        return $this->parseFilenameToClass($fileName);
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassLike|null
     */
    private function parseFilenameToClass(string $fileName)
    {
        if (isset($this->classesByFilename[$fileName])) {
            return $this->classesByFilename[$fileName];
        }
        try {
            $stmts = $this->smartPhpParser->parseFile($fileName);
        } catch (Throwable $exception) {
            // not reachable
            return null;
        }
        $class = $this->nodeFinder->findFirstInstanceOf($stmts, ClassLike::class);
        if (!$class instanceof ClassLike) {
            return null;
        }
        $this->classesByFilename[$fileName] = $class;
        return $class;
    }
}
