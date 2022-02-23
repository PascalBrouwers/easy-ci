<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace EasyCI20220223\Nette\Neon\Node;

use EasyCI20220223\Nette\Neon\Entity;
use EasyCI20220223\Nette\Neon\Node;
/** @internal */
final class EntityNode extends \EasyCI20220223\Nette\Neon\Node
{
    /** @var Node */
    public $value;
    /** @var ArrayItemNode[] */
    public $attributes = [];
    public function __construct(\EasyCI20220223\Nette\Neon\Node $value, array $attributes, int $startPos = null, int $endPos = null)
    {
        $this->value = $value;
        $this->attributes = $attributes;
        $this->startPos = $startPos;
        $this->endPos = $endPos ?? $startPos;
    }
    public function toValue() : \EasyCI20220223\Nette\Neon\Entity
    {
        return new \EasyCI20220223\Nette\Neon\Entity($this->value->toValue(), \EasyCI20220223\Nette\Neon\Node\ArrayItemNode::itemsToArray($this->attributes));
    }
    public function toString() : string
    {
        return $this->value->toString() . '(' . ($this->attributes ? \EasyCI20220223\Nette\Neon\Node\ArrayItemNode::itemsToInlineString($this->attributes) : '') . ')';
    }
    public function getSubNodes() : array
    {
        $res = [&$this->value];
        foreach ($this->attributes as &$item) {
            $res[] =& $item;
        }
        return $res;
    }
}
