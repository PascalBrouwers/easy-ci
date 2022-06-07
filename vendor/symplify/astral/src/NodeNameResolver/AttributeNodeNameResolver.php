<?php

declare (strict_types=1);
namespace EasyCI20220607\Symplify\Astral\NodeNameResolver;

use EasyCI20220607\PhpParser\Node;
use EasyCI20220607\PhpParser\Node\Attribute;
use EasyCI20220607\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(Node $node) : ?string
    {
        return $node->name->toString();
    }
}
