<?php

declare (strict_types=1);
namespace EasyCI20220305\Symplify\PackageBuilder\Composer;

use EasyCI20220305\Composer\Autoload\ClassLoader;
use ReflectionClass;
/**
 * @api
 * @see \Symplify\PackageBuilder\Tests\Composer\VendorDirProviderTest
 */
final class VendorDirProvider
{
    public function provide() : string
    {
        $rootFolder = \getenv('SystemDrive', \true) . \DIRECTORY_SEPARATOR;
        $path = __DIR__;
        while (\substr_compare($path, 'vendor', -\strlen('vendor')) !== 0 && $path !== $rootFolder) {
            $path = \dirname($path);
        }
        if ($path !== $rootFolder) {
            return $path;
        }
        return $this->reflectionFallback();
    }
    private function reflectionFallback() : string
    {
        $reflectionClass = new \ReflectionClass(\EasyCI20220305\Composer\Autoload\ClassLoader::class);
        return \dirname($reflectionClass->getFileName(), 2);
    }
}
