<?php

namespace Milhojas\Library\Messaging\QueryBus\Loader;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Adapter class to use the Symfony Container as Class Loader for the Messaging system.
 */
class SymfonyContainerLoader implements Loader
{
    private $container;

    /**
     * Injects and instance of the symfony container.
     *
     * @param ContainerInterface $symfonyContainer Uses the symfony container as loader for classes
     */
    public function __construct(ContainerInterface $symfonyContainer)
    {
        $this->container = $symfonyContainer;
    }
    /**
     * Loads the class given a string identifier definer in the services.yml configuration.
     *
     * @param string $className a class name or identifier
     *
     * @return object of the desired class
     */
    public function get($className)
    {
        return $this->container->get($className);
    }
}
