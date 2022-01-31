<?php

declare (strict_types=1);
namespace EasyCI20220131;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use EasyCI20220131\Symplify\SmartFileSystem\SmartFileSystem;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\EasyCI20220131\Symplify\SmartFileSystem\SmartFileSystem::class);
};
