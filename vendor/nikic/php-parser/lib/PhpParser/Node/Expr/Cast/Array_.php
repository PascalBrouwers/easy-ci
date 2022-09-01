<?php

declare (strict_types=1);
namespace EasyCI202209\PhpParser\Node\Expr\Cast;

use EasyCI202209\PhpParser\Node\Expr\Cast;
class Array_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Array';
    }
}
