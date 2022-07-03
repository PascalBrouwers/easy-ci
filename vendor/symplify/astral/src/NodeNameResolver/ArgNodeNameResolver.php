<?php

declare (strict_types=1);
namespace EasyCI202207\Symplify\Astral\NodeNameResolver;

use EasyCI202207\PhpParser\Node;
use EasyCI202207\PhpParser\Node\Arg;
use EasyCI202207\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof Arg;
    }
    /**
     * @param Arg $node
     */
    public function resolve(Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
