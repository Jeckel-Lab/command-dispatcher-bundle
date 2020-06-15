<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 03/02/2020
 */

declare(strict_types=1);

namespace JeckelLab\CommandDispatcherBundle\CommandBus\Decorator;

use Doctrine\ORM\EntityManagerInterface;
use JeckelLab\Contract\Core\CommandDispatcher\Command\Command;
use JeckelLab\Contract\Core\CommandDispatcher\CommandBus\CommandBus;
use JeckelLab\Contract\Core\CommandDispatcher\CommandResponse\CommandResponse;

/**
 * Class EntityFlushDecorator
 * @package App\Core\CommandBus
 */
class EntityFlushDecorator implements CommandBus
{
    /** @var CommandBus */
    protected $next;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * EntityFlushDecorator constructor.
     * @param CommandBus    $next
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CommandBus $next, EntityManagerInterface $entityManager)
    {
        $this->next = $next;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Command $command
     * @return CommandResponse
     */
    public function dispatch(Command $command): CommandResponse
    {
        $response = $this->next->dispatch($command);

        $this->entityManager->flush();

        return $response;
    }
}
