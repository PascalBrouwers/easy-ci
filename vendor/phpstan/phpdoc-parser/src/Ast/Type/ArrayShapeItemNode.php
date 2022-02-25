<?php

declare (strict_types=1);
namespace EasyCI20220225\PHPStan\PhpDocParser\Ast\Type;

use EasyCI20220225\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use EasyCI20220225\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use EasyCI20220225\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ArrayShapeItemNode implements \EasyCI20220225\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var ConstExprIntegerNode|ConstExprStringNode|IdentifierTypeNode|null */
    public $keyName;
    /** @var bool */
    public $optional;
    /** @var TypeNode */
    public $valueType;
    /**
     * @param ConstExprIntegerNode|ConstExprStringNode|IdentifierTypeNode|null $keyName
     */
    public function __construct($keyName, bool $optional, \EasyCI20220225\PHPStan\PhpDocParser\Ast\Type\TypeNode $valueType)
    {
        $this->keyName = $keyName;
        $this->optional = $optional;
        $this->valueType = $valueType;
    }
    public function __toString() : string
    {
        if ($this->keyName !== null) {
            return \sprintf('%s%s: %s', (string) $this->keyName, $this->optional ? '?' : '', (string) $this->valueType);
        }
        return (string) $this->valueType;
    }
}
