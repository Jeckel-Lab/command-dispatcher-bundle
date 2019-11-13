<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 13/11/2019
 */

namespace JeckelLab\CommandDispatcherBundle;

use JeckelLab\CommandDispatcherBundle\Compiler\RegisterServicesPass;
use JeckelLab\CommandDispatcherBundle\Compiler\CommandHandlerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class JeckelLabCommandDispatcherBundle
 */
class JeckelLabCommandDispatcherBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterServicesPass());
        $container->addCompilerPass(new CommandHandlerPass('command_dispatcher.handler'));
    }
}
