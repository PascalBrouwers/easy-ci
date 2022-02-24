<?php

declare (strict_types=1);
namespace EasyCI20220224\PhpParser\Node\Scalar\MagicConst;

use EasyCI20220224\PhpParser\Node\Scalar\MagicConst;
class Method extends \EasyCI20220224\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__METHOD__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Method';
    }
}
