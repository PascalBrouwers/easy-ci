<?php

namespace EasyCI20220607;

if (\PHP_VERSION_ID < 80100) {
    #[\Attribute(\Attribute::TARGET_METHOD)]
    final class ReturnTypeWillChange
    {
        public function __construct()
        {
        }
    }
}
