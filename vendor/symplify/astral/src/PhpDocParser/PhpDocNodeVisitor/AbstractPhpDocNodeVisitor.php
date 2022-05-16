<?php

declare (strict_types=1);
namespace EasyCI20220516\Symplify\Astral\PhpDocParser\PhpDocNodeVisitor;

use EasyCI20220516\PHPStan\PhpDocParser\Ast\Node;
use EasyCI20220516\Symplify\Astral\PhpDocParser\Contract\PhpDocNodeVisitorInterface;
/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitorAbstract.php
 */
abstract class AbstractPhpDocNodeVisitor implements \EasyCI20220516\Symplify\Astral\PhpDocParser\Contract\PhpDocNodeVisitorInterface
{
    public function beforeTraverse(\EasyCI20220516\PHPStan\PhpDocParser\Ast\Node $node) : void
    {
    }
    /**
     * @return int|\PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(\EasyCI20220516\PHPStan\PhpDocParser\Ast\Node $node)
    {
        return null;
    }
    /**
     * @return int|\PhpParser\Node|mixed[]|null Replacement node (or special return)
     */
    public function leaveNode(\EasyCI20220516\PHPStan\PhpDocParser\Ast\Node $node)
    {
        return null;
    }
    public function afterTraverse(\EasyCI20220516\PHPStan\PhpDocParser\Ast\Node $node) : void
    {
    }
}
