<?php

declare (strict_types=1);
namespace EasyCI20220612\Symplify\SymplifyKernel\Config\Loader;

use EasyCI20220612\Symfony\Component\Config\FileLocator;
use EasyCI20220612\Symfony\Component\Config\Loader\DelegatingLoader;
use EasyCI20220612\Symfony\Component\Config\Loader\GlobFileLoader;
use EasyCI20220612\Symfony\Component\Config\Loader\LoaderResolver;
use EasyCI20220612\Symfony\Component\DependencyInjection\ContainerBuilder;
use EasyCI20220612\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
use EasyCI20220612\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface;
final class ParameterMergingLoaderFactory implements LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \EasyCI20220612\Symfony\Component\Config\Loader\LoaderInterface
    {
        $fileLocator = new FileLocator([$currentWorkingDirectory]);
        $loaders = [new GlobFileLoader($fileLocator), new ParameterMergingPhpFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new LoaderResolver($loaders);
        return new DelegatingLoader($loaderResolver);
    }
}
