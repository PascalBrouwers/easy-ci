<?php

declare (strict_types=1);
namespace EasyCI20220608\PhpParser\Node\Expr\BinaryOp;

use EasyCI20220608\PhpParser\Node\Expr\BinaryOp;
class BitwiseOr extends BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '|';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BitwiseOr';
    }
}
