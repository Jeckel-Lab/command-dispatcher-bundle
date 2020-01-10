<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 13/11/2019
 */

namespace JeckelLab\CommandDispatcherBundle;

use JeckelLab\CommandDispatcherBundle\Compiler\CommandHandlerPass;
use JeckelLab\CommandDispatcherBundle\DependencyInjection\CommandDispatcherExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class JeckelLabCommandDispatcherBundle
 */
class JeckelLabCommandDispatcherBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CommandHandlerPass('command_dispatcher.handler'));
    }

    /**
     * @return CommandDispatcherExtension|ExtensionInterface|null
     */
    public function getContainerExtension()
    {
        return new CommandDispatcherExtension();
    }
}
