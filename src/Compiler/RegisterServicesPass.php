<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 13/11/2019
 */

namespace JeckelLab\CommandDispatcherBundle\Compiler;

use JeckelLab\CommandDispatcher\CommandDispatcher;
use JeckelLab\CommandDispatcher\CommandDispatcherInterface;
use JeckelLab\CommandDispatcher\Resolver\CommandHandlerResolver;
use JeckelLab\CommandDispatcher\Resolver\CommandHandlerResolverInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class RegisterServicesPass
 * @package Compiler
 */
class RegisterServicesPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        if (! $container->hasDefinition(CommandHandlerResolverInterface::class)) {
            $container->setDefinition(
                CommandHandlerResolverInterface::class,
                (new Definition(CommandHandlerResolver::class, ['%command_handler.handlers.map%']))
                    ->setAutowired(true)
            );
        }
        if (! $container->hasDefinition(CommandDispatcherInterface::class)) {
            $container->autowire(CommandDispatcherInterface::class, CommandDispatcher::class);
        }
    }
}
