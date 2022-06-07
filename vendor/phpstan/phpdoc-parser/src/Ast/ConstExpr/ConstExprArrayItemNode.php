<?php

declare (strict_types=1);
namespace EasyCI20220607\PHPStan\PhpDocParser\Ast\ConstExpr;

use EasyCI20220607\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprArrayItemNode implements ConstExprNode
{
    use NodeAttributes;
    /** @var ConstExprNode|null */
    public $key;
    /** @var ConstExprNode */
    public $value;
    public function __construct(?ConstExprNode $key, ConstExprNode $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
    public function __toString() : string
    {
        if ($this->key !== null) {
            return "{$this->key} => {$this->value}";
        }
        return "{$this->value}";
    }
}
