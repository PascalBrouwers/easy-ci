<?php

declare (strict_types=1);
namespace EasyCI20220607;

use EasyCI20220607\SebastianBergmann\Diff\Differ;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use EasyCI20220607\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter;
use EasyCI20220607\Symplify\PackageBuilder\Console\Output\ConsoleDiffer;
use EasyCI20220607\Symplify\PackageBuilder\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use EasyCI20220607\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->set(\EasyCI20220607\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\EasyCI20220607\Symplify\PackageBuilder\Console\Output\ConsoleDiffer::class);
    $services->set(\EasyCI20220607\Symplify\PackageBuilder\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class);
    $services->set(\EasyCI20220607\SebastianBergmann\Diff\Differ::class);
    $services->set(\EasyCI20220607\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
