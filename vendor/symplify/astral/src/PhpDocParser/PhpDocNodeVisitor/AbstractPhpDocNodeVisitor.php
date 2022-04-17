<?php

declare (strict_types=1);
namespace EasyCI20220417\Symplify\Astral\PhpDocParser\PhpDocNodeVisitor;

use EasyCI20220417\PHPStan\PhpDocParser\Ast\Node;
use EasyCI20220417\Symplify\Astral\PhpDocParser\Contract\PhpDocNodeVisitorInterface;
/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitorAbstract.php
 */
abstract class AbstractPhpDocNodeVisitor implements \EasyCI20220417\Symplify\Astral\PhpDocParser\Contract\PhpDocNodeVisitorInterface
{
    public function beforeTraverse(\EasyCI20220417\PHPStan\PhpDocParser\Ast\Node $node) : void
    {
    }
    /**
     * @return int|\PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(\EasyCI20220417\PHPStan\PhpDocParser\Ast\Node $node)
    {
        return null;
    }
    /**
     * @return mixed[]|int|\PhpParser\Node|null Replacement node (or special return)
     */
    public function leaveNode(\EasyCI20220417\PHPStan\PhpDocParser\Ast\Node $node)
    {
        return null;
    }
    public function afterTraverse(\EasyCI20220417\PHPStan\PhpDocParser\Ast\Node $node) : void
    {
    }
}
