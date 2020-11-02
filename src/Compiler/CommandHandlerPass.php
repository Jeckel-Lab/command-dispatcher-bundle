<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 12/11/2019
 */

declare(strict_types=1);

namespace JeckelLab\CommandDispatcherBundle\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * Class CommandHandlerPass
 * @package JeckelLab\ContainerDispatcher\Compiler
 */
class CommandHandlerPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    protected $handlersTag;

    /**
     * CommandHandlerPass constructor.
     * @param string $handlersTag
     */
    public function __construct(string $handlersTag)
    {
        $this->handlersTag = $handlersTag;
    }

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        $handlerMaps = [];
        // Find command handlers
        foreach (array_keys($container->findTaggedServiceIds($this->handlersTag)) as $serviceId) {
            $classname = $container->getDefinition((string) $serviceId)->getClass();
            if (null === $classname) {
                throw new RuntimeException(sprintf('Unable to find service with id: %s', $serviceId));
            }

            $aliasId = 'command_handler.handler.alias.' . $classname;
            $container->setAlias($aliasId, (string) $serviceId)->setPublic(true);

            /** @var string[] $commands */
            $commands = call_user_func([$classname, 'getHandledCommands']);
            foreach ($commands as $command) {
                $handlerMaps[$command] = $aliasId;
            }
        }

        $container->setParameter('command_handler.handlers.map', $handlerMaps);
    }
}
