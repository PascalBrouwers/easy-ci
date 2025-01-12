<?php

declare (strict_types=1);
namespace EasyCI202209\Symplify\SymplifyKernel\HttpKernel;

use EasyCI202209\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use EasyCI202209\Symfony\Component\DependencyInjection\Container;
use EasyCI202209\Symfony\Component\DependencyInjection\ContainerInterface;
use EasyCI202209\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use EasyCI202209\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use EasyCI202209\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use EasyCI202209\Symplify\SymplifyKernel\ContainerBuilderFactory;
use EasyCI202209\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use EasyCI202209\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use EasyCI202209\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig;
/**
 * @api
 */
abstract class AbstractSymplifyKernel implements LightKernelInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container|null
     */
    private $container = null;
    /**
     * @param string[] $configFiles
     * @param CompilerPassInterface[] $compilerPasses
     * @param ExtensionInterface[] $extensions
     */
    public function create(array $configFiles, array $compilerPasses = [], array $extensions = []) : ContainerInterface
    {
        $containerBuilderFactory = new ContainerBuilderFactory(new ParameterMergingLoaderFactory());
        $compilerPasses[] = new AutowireArrayParameterCompilerPass();
        $configFiles[] = SymplifyKernelConfig::FILE_PATH;
        $containerBuilder = $containerBuilderFactory->create($configFiles, $compilerPasses, $extensions);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \EasyCI202209\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof Container) {
            throw new ShouldNotHappenException();
        }
        return $this->container;
    }
}
