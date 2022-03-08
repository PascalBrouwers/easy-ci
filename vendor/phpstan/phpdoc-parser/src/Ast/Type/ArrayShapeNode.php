<?php

declare (strict_types=1);
namespace EasyCI20220308\PHPStan\PhpDocParser\Ast\Type;

use EasyCI20220308\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ArrayShapeNode implements \EasyCI20220308\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var ArrayShapeItemNode[] */
    public $items;
    public function __construct(array $items)
    {
        $this->items = $items;
    }
    public function __toString() : string
    {
        return 'array{' . \implode(', ', $this->items) . '}';
    }
}
