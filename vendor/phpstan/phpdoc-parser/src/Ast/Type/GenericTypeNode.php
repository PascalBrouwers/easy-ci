<?php

declare (strict_types=1);
namespace EasyCI20220224\PHPStan\PhpDocParser\Ast\Type;

use EasyCI20220224\PHPStan\PhpDocParser\Ast\NodeAttributes;
class GenericTypeNode implements \EasyCI20220224\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var IdentifierTypeNode */
    public $type;
    /** @var TypeNode[] */
    public $genericTypes;
    public function __construct(\EasyCI20220224\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $type, array $genericTypes)
    {
        $this->type = $type;
        $this->genericTypes = $genericTypes;
    }
    public function __toString() : string
    {
        return $this->type . '<' . \implode(', ', $this->genericTypes) . '>';
    }
}