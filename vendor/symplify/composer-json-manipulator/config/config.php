<?php

declare (strict_types=1);
namespace EasyCI20220609;

use EasyCI20220609\Symfony\Component\Console\Style\SymfonyStyle;
use EasyCI20220609\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use EasyCI20220609\Symplify\ComposerJsonManipulator\ValueObject\Option;
use EasyCI20220609\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use EasyCI20220609\Symplify\PackageBuilder\Parameter\ParameterProvider;
use EasyCI20220609\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use EasyCI20220609\Symplify\SmartFileSystem\SmartFileSystem;
use function EasyCI20220609\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('EasyCI20220609\Symplify\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(SmartFileSystem::class);
    $services->set(PrivatesCaller::class);
    $services->set(ParameterProvider::class)->args([service('service_container')]);
    $services->set(SymfonyStyleFactory::class);
    $services->set(SymfonyStyle::class)->factory([service(SymfonyStyleFactory::class), 'create']);
};
