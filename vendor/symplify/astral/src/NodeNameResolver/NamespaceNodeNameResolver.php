<?php

declare (strict_types=1);
namespace EasyCI202208\Symplify\Astral\NodeNameResolver;

use EasyCI202208\PhpParser\Node;
use EasyCI202208\PhpParser\Node\Stmt\Namespace_;
use EasyCI202208\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof Namespace_;
    }
    /**
     * @param Namespace_ $node
     */
    public function resolve(Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return $node->name->toString();
    }
}
