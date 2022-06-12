<?php

declare (strict_types=1);
namespace EasyCI20220612\PhpParser\Node\Expr\AssignOp;

use EasyCI20220612\PhpParser\Node\Expr\AssignOp;
class BitwiseOr extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_BitwiseOr';
    }
}
