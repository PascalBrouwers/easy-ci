<?php

declare (strict_types=1);
namespace EasyCI20220509\PHPStan\PhpDocParser\Ast\ConstExpr;

use EasyCI20220509\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function implode;
class ConstExprArrayNode implements \EasyCI20220509\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    /** @var ConstExprArrayItemNode[] */
    public $items;
    /**
     * @param ConstExprArrayItemNode[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }
    public function __toString() : string
    {
        return '[' . \implode(', ', $this->items) . ']';
    }
}
