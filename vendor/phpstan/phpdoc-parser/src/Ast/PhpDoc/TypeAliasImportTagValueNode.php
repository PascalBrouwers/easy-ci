<?php

declare (strict_types=1);
namespace EasyCI20220607\PHPStan\PhpDocParser\Ast\PhpDoc;

use EasyCI20220607\PHPStan\PhpDocParser\Ast\NodeAttributes;
use EasyCI20220607\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use function trim;
class TypeAliasImportTagValueNode implements \EasyCI20220607\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var string */
    public $importedAlias;
    /** @var IdentifierTypeNode */
    public $importedFrom;
    /** @var string|null */
    public $importedAs;
    public function __construct(string $importedAlias, \EasyCI20220607\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $importedFrom, ?string $importedAs)
    {
        $this->importedAlias = $importedAlias;
        $this->importedFrom = $importedFrom;
        $this->importedAs = $importedAs;
    }
    public function __toString() : string
    {
        return \trim("{$this->importedAlias} from {$this->importedFrom}" . ($this->importedAs !== null ? " as {$this->importedAs}" : ''));
    }
}
