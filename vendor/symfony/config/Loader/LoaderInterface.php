<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace EasyCI20220116\Symfony\Component\Config\Loader;

/**
 * LoaderInterface is the interface implemented by all loader classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface LoaderInterface
{
    /**
     * Loads a resource.
     *
     * @return mixed
     *
     * @throws \Exception If something went wrong
     * @param mixed $resource
     * @param string|null $type
     */
    public function load($resource, $type = null);
    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed $resource A resource
     *
     * @return bool
     */
    public function supports($resource, string $type = null);
    /**
     * Gets the loader resolver.
     *
     * @return LoaderResolverInterface
     */
    public function getResolver();
    /**
     * Sets the loader resolver.
     */
    public function setResolver(\EasyCI20220116\Symfony\Component\Config\Loader\LoaderResolverInterface $resolver);
}