<?php

declare (strict_types=1);
namespace EasyCI20220529\Symplify\Astral\NodeValue\NodeValueResolver;

use EasyCI20220529\PhpParser\Node\Expr;
use EasyCI20220529\PhpParser\Node\Expr\ClassConstFetch;
use EasyCI20220529\PhpParser\Node\Stmt\ClassLike;
use ReflectionClassConstant;
use EasyCI20220529\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use EasyCI20220529\Symplify\Astral\Naming\SimpleNameResolver;
use EasyCI20220529\Symplify\Astral\NodeFinder\SimpleNodeFinder;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<ClassConstFetch>
 */
final class ClassConstFetchValueResolver implements \EasyCI20220529\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \Symplify\Astral\NodeFinder\SimpleNodeFinder
     */
    private $simpleNodeFinder;
    public function __construct(\EasyCI20220529\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \EasyCI20220529\Symplify\Astral\NodeFinder\SimpleNodeFinder $simpleNodeFinder)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->simpleNodeFinder = $simpleNodeFinder;
    }
    public function getType() : string
    {
        return \EasyCI20220529\PhpParser\Node\Expr\ClassConstFetch::class;
    }
    /**
     * @param ClassConstFetch $expr
     * @return mixed
     */
    public function resolve(\EasyCI20220529\PhpParser\Node\Expr $expr, string $currentFilePath)
    {
        $className = $this->simpleNameResolver->getName($expr->class);
        if ($className === 'self') {
            $classLike = $this->simpleNodeFinder->findFirstParentByType($expr, \EasyCI20220529\PhpParser\Node\Stmt\ClassLike::class);
            if (!$classLike instanceof \EasyCI20220529\PhpParser\Node\Stmt\ClassLike) {
                return null;
            }
            $className = $this->simpleNameResolver->getName($classLike);
        }
        if ($className === null) {
            return null;
        }
        $constantName = $this->simpleNameResolver->getName($expr->name);
        if ($constantName === null) {
            return null;
        }
        if ($constantName === 'class') {
            return $className;
        }
        if (!\class_exists($className) && !\interface_exists($className)) {
            return null;
        }
        $reflectionClassConstant = new \ReflectionClassConstant($className, $constantName);
        return $reflectionClassConstant->getValue();
    }
}
