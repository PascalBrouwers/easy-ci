<?php

declare (strict_types=1);
namespace EasyCI20220613\PhpParser\Node\Expr\BinaryOp;

use EasyCI20220613\PhpParser\Node\Expr\BinaryOp;
class NotEqual extends BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '!=';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_NotEqual';
    }
}
