<?php

declare (strict_types=1);
namespace EasyCI20220613\PHPStan\PhpDocParser\Ast\Type;

use EasyCI20220613\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ArrayTypeNode implements TypeNode
{
    use NodeAttributes;
    /** @var TypeNode */
    public $type;
    public function __construct(TypeNode $type)
    {
        $this->type = $type;
    }
    public function __toString() : string
    {
        return $this->type . '[]';
    }
}
