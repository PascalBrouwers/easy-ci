<?php

declare (strict_types=1);
namespace EasyCI20220607\Symplify\Astral\NodeNameResolver;

use EasyCI20220607\PhpParser\Node;
use EasyCI20220607\PhpParser\Node\Expr;
use EasyCI20220607\PhpParser\Node\Expr\FuncCall;
use EasyCI20220607\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(Node $node) : ?string
    {
        if ($node->name instanceof Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
