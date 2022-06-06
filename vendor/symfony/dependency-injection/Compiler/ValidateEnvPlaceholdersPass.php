<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace EasyCI20220606\Symfony\Component\DependencyInjection\Compiler;

use EasyCI20220606\Symfony\Component\Config\Definition\BaseNode;
use EasyCI20220606\Symfony\Component\Config\Definition\ConfigurationInterface;
use EasyCI20220606\Symfony\Component\Config\Definition\Processor;
use EasyCI20220606\Symfony\Component\DependencyInjection\ContainerBuilder;
use EasyCI20220606\Symfony\Component\DependencyInjection\Extension\ConfigurationExtensionInterface;
use EasyCI20220606\Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag;
use EasyCI20220606\Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
/**
 * Validates environment variable placeholders used in extension configuration with dummy values.
 *
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class ValidateEnvPlaceholdersPass implements \EasyCI20220606\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private const TYPE_FIXTURES = ['array' => [], 'bool' => \false, 'float' => 0.0, 'int' => 0, 'string' => ''];
    /**
     * @var mixed[]
     */
    private $extensionConfig = [];
    /**
     * {@inheritdoc}
     */
    public function process(\EasyCI20220606\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $this->extensionConfig = [];
        if (!\class_exists(\EasyCI20220606\Symfony\Component\Config\Definition\BaseNode::class) || !($extensions = $container->getExtensions())) {
            return;
        }
        $resolvingBag = $container->getParameterBag();
        if (!$resolvingBag instanceof \EasyCI20220606\Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag) {
            return;
        }
        $defaultBag = new \EasyCI20220606\Symfony\Component\DependencyInjection\ParameterBag\ParameterBag($resolvingBag->all());
        $envTypes = $resolvingBag->getProvidedTypes();
        foreach ($resolvingBag->getEnvPlaceholders() + $resolvingBag->getUnusedEnvPlaceholders() as $env => $placeholders) {
            $values = [];
            if (\false === ($i = \strpos($env, ':'))) {
                $default = $defaultBag->has("env({$env})") ? $defaultBag->get("env({$env})") : self::TYPE_FIXTURES['string'];
                $defaultType = null !== $default ? \get_debug_type($default) : 'string';
                $values[$defaultType] = $default;
            } else {
                $prefix = \substr($env, 0, $i);
                foreach ($envTypes[$prefix] ?? ['string'] as $type) {
                    $values[$type] = self::TYPE_FIXTURES[$type] ?? null;
                }
            }
            foreach ($placeholders as $placeholder) {
                \EasyCI20220606\Symfony\Component\Config\Definition\BaseNode::setPlaceholder($placeholder, $values);
            }
        }
        $processor = new \EasyCI20220606\Symfony\Component\Config\Definition\Processor();
        foreach ($extensions as $name => $extension) {
            if (!($extension instanceof \EasyCI20220606\Symfony\Component\DependencyInjection\Extension\ConfigurationExtensionInterface || $extension instanceof \EasyCI20220606\Symfony\Component\Config\Definition\ConfigurationInterface) || !($config = \array_filter($container->getExtensionConfig($name)))) {
                // this extension has no semantic configuration or was not called
                continue;
            }
            $config = $resolvingBag->resolveValue($config);
            if ($extension instanceof \EasyCI20220606\Symfony\Component\Config\Definition\ConfigurationInterface) {
                $configuration = $extension;
            } elseif (null === ($configuration = $extension->getConfiguration($config, $container))) {
                continue;
            }
            $this->extensionConfig[$name] = $processor->processConfiguration($configuration, $config);
        }
        $resolvingBag->clearUnusedEnvPlaceholders();
    }
    /**
     * @internal
     */
    public function getExtensionConfig() : array
    {
        try {
            return $this->extensionConfig;
        } finally {
            $this->extensionConfig = [];
        }
    }
}
