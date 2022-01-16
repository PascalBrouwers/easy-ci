<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace EasyCI20220116\Nette\Neon;

/**
 * Parser for Nette Object Notation.
 * @internal
 */
final class Decoder
{
    /**
     * Decodes a NEON string.
     * @return mixed
     */
    public function decode(string $input)
    {
        $node = $this->parseToNode($input);
        return $node->toValue();
    }
    public function parseToNode(string $input) : \EasyCI20220116\Nette\Neon\Node
    {
        $lexer = new \EasyCI20220116\Nette\Neon\Lexer();
        $parser = new \EasyCI20220116\Nette\Neon\Parser();
        $tokens = $lexer->tokenize($input);
        return $parser->parse($tokens);
    }
}