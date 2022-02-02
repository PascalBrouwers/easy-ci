<?php

declare (strict_types=1);
namespace EasyCI20220202\PhpParser\Node;

use EasyCI20220202\PhpParser\NodeAbstract;
class Const_ extends \EasyCI20220202\PhpParser\NodeAbstract
{
    /** @var Identifier Name */
    public $name;
    /** @var Expr Value */
    public $value;
    /** @var Name Namespaced name (if using NameResolver) */
    public $namespacedName;
    /**
     * Constructs a const node for use in class const and const statements.
     *
     * @param string|Identifier $name       Name
     * @param Expr              $value      Value
     * @param array             $attributes Additional attributes
     */
    public function __construct($name, \EasyCI20220202\PhpParser\Node\Expr $value, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = \is_string($name) ? new \EasyCI20220202\PhpParser\Node\Identifier($name) : $name;
        $this->value = $value;
    }
    public function getSubNodeNames() : array
    {
        return ['name', 'value'];
    }
    public function getType() : string
    {
        return 'Const';
    }
}
