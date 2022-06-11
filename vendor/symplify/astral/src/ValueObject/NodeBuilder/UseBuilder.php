<?php

declare (strict_types=1);
namespace EasyCI20220611\Symplify\Astral\ValueObject\NodeBuilder;

use EasyCI20220611\PhpParser\Builder\Use_;
use EasyCI20220611\PhpParser\Node\Name;
use EasyCI20220611\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * @api
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends Use_
{
    /**
     * @param \PhpParser\Node\Name|string $name
     */
    public function __construct($name, int $type = UseStmt::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
