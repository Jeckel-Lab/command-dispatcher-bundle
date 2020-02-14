<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 03/02/2020
 */

declare(strict_types=1);

namespace JeckelLab\CommandDispatcherBundle\CommandBus\Decorator;

use Doctrine\ORM\EntityManagerInterface;
use JeckelLab\CommandDispatcher\Command\CommandInterface;
use JeckelLab\CommandDispatcher\CommandBus\CommandBusInterface;
use JeckelLab\CommandDispatcher\CommandResponse\CommandResponseInterface;

/**
 * Class EntityFlushDecorator
 * @package App\Core\CommandBus
 */
class EntityFlushDecorator implements CommandBusInterface
{
    /** @var CommandBusInterface */
    protected $next;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * EntityFlushDecorator constructor.
     * @param CommandBusInterface    $next
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CommandBusInterface $next, EntityManagerInterface $entityManager)
    {
        $this->next = $next;
        $this->entityManager = $entityManager;
    }

    /**
     * @param CommandInterface $command
     * @return CommandResponseInterface
     */
    public function dispatch(CommandInterface $command): CommandResponseInterface
    {
        $response = $this->next->dispatch($command);

        $this->entityManager->flush();

        return $response;
    }
}
