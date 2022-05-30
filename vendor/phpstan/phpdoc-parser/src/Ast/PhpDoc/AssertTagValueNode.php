<?php

declare (strict_types=1);
namespace EasyCI20220530\PHPStan\PhpDocParser\Ast\PhpDoc;

use EasyCI20220530\PHPStan\PhpDocParser\Ast\NodeAttributes;
use EasyCI20220530\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use function trim;
class AssertTagValueNode implements \EasyCI20220530\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var TypeNode */
    public $type;
    /** @var string */
    public $parameter;
    /** @var bool */
    public $isNegated;
    /** @var string (may be empty) */
    public $description;
    public function __construct(\EasyCI20220530\PHPStan\PhpDocParser\Ast\Type\TypeNode $type, string $parameter, bool $isNegated, string $description)
    {
        $this->type = $type;
        $this->parameter = $parameter;
        $this->isNegated = $isNegated;
        $this->description = $description;
    }
    public function __toString() : string
    {
        $isNegated = $this->isNegated ? '!' : '';
        return \trim("{$this->type} {$isNegated}{$this->parameter} {$this->description}");
    }
}
