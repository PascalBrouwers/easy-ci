<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace EasyCI20220116\Nette\Neon\Node;

/** @internal */
final class InlineArrayNode extends \EasyCI20220116\Nette\Neon\Node\ArrayNode
{
    /** @var string */
    public $bracket;
    public function __construct(string $bracket, int $pos = null)
    {
        $this->bracket = $bracket;
        $this->startPos = $this->endPos = $pos;
    }
    public function toString() : string
    {
        return $this->bracket . \EasyCI20220116\Nette\Neon\Node\ArrayItemNode::itemsToInlineString($this->items) . ['[' => ']', '{' => '}', '(' => ')'][$this->bracket];
    }
}