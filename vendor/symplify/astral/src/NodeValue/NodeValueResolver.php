<?php

declare (strict_types=1);
namespace EasyCI20220608\Symplify\Astral\NodeValue;

use EasyCI20220608\PhpParser\ConstExprEvaluationException;
use EasyCI20220608\PhpParser\ConstExprEvaluator;
use EasyCI20220608\PhpParser\Node\Expr;
use EasyCI20220608\PhpParser\Node\Expr\Cast;
use EasyCI20220608\PhpParser\Node\Expr\Instanceof_;
use EasyCI20220608\PhpParser\Node\Expr\MethodCall;
use EasyCI20220608\PhpParser\Node\Expr\PropertyFetch;
use EasyCI20220608\PhpParser\Node\Expr\Variable;
use EasyCI20220608\PHPStan\Analyser\Scope;
use EasyCI20220608\PHPStan\Type\ConstantScalarType;
use EasyCI20220608\PHPStan\Type\UnionType;
use EasyCI20220608\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use EasyCI20220608\Symplify\Astral\Exception\ShouldNotHappenException;
use EasyCI20220608\Symplify\Astral\Naming\SimpleNameResolver;
use EasyCI20220608\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use EasyCI20220608\Symplify\Astral\NodeValue\NodeValueResolver\ClassConstFetchValueResolver;
use EasyCI20220608\Symplify\Astral\NodeValue\NodeValueResolver\ConstFetchValueResolver;
use EasyCI20220608\Symplify\Astral\NodeValue\NodeValueResolver\FuncCallValueResolver;
use EasyCI20220608\Symplify\Astral\NodeValue\NodeValueResolver\MagicConstValueResolver;
use EasyCI20220608\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 */
final class NodeValueResolver
{
    /**
     * @var \PhpParser\ConstExprEvaluator
     */
    private $constExprEvaluator;
    /**
     * @var string|null
     */
    private $currentFilePath;
    /**
     * @var \Symplify\Astral\NodeValue\UnionTypeValueResolver
     */
    private $unionTypeValueResolver;
    /**
     * @var array<NodeValueResolverInterface>
     */
    private $nodeValueResolvers = [];
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \Symplify\PackageBuilder\Php\TypeChecker
     */
    private $typeChecker;
    public function __construct(SimpleNameResolver $simpleNameResolver, TypeChecker $typeChecker, SimpleNodeFinder $simpleNodeFinder)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->typeChecker = $typeChecker;
        $this->constExprEvaluator = new ConstExprEvaluator(function (Expr $expr) {
            return $this->resolveByNode($expr);
        });
        $this->unionTypeValueResolver = new UnionTypeValueResolver();
        $this->nodeValueResolvers[] = new ClassConstFetchValueResolver($this->simpleNameResolver, $simpleNodeFinder);
        $this->nodeValueResolvers[] = new ConstFetchValueResolver($this->simpleNameResolver);
        $this->nodeValueResolvers[] = new MagicConstValueResolver();
        $this->nodeValueResolvers[] = new FuncCallValueResolver($this->simpleNameResolver, $this->constExprEvaluator);
    }
    /**
     * @return mixed
     */
    public function resolveWithScope(Expr $expr, Scope $scope)
    {
        $this->currentFilePath = $scope->getFile();
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (ConstExprEvaluationException $exception) {
        }
        $exprType = $scope->getType($expr);
        if ($exprType instanceof ConstantScalarType) {
            return $exprType->getValue();
        }
        if ($exprType instanceof UnionType) {
            return $this->unionTypeValueResolver->resolveConstantTypes($exprType);
        }
        return null;
    }
    /**
     * @return mixed
     */
    public function resolve(Expr $expr, string $filePath)
    {
        $this->currentFilePath = $filePath;
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (ConstExprEvaluationException $exception) {
            return null;
        }
    }
    /**
     * @return mixed
     */
    private function resolveByNode(Expr $expr)
    {
        if ($this->currentFilePath === null) {
            throw new ShouldNotHappenException();
        }
        foreach ($this->nodeValueResolvers as $nodeValueResolver) {
            if (\is_a($expr, $nodeValueResolver->getType(), \true)) {
                return $nodeValueResolver->resolve($expr, $this->currentFilePath);
            }
        }
        // these values cannot be resolved in reliable way
        if ($this->typeChecker->isInstanceOf($expr, [Variable::class, Cast::class, MethodCall::class, PropertyFetch::class, Instanceof_::class])) {
            throw new ConstExprEvaluationException();
        }
        return null;
    }
}
