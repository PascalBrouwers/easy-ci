<?php

declare (strict_types=1);
namespace EasyCI20220609\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use EasyCI20220609\PHPUnit\Framework\TestCase;
use EasyCI20220609\Symplify\SmartFileSystem\SmartFileSystem;
use EasyCI20220609\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use EasyCI20220609\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new ContainerBuilderFactory(new ParameterMergingLoaderFactory());
        $containerBuilder = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $containerBuilder->has(SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}
