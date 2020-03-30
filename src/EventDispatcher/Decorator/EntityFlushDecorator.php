<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 30/03/2020
 */

declare(strict_types=1);

namespace JeckelLab\CommandDispatcherBundle\EventDispatcher\Decorator;

use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Class EntityFlushDecorator
 * @package JeckelLab\CommandDispatcherBundle\EventDispatcher\Decorator
 */
class EntityFlushDecorator implements EventDispatcherInterface
{
    /** @var EventDispatcherInterface */
    protected $next;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * EntityFlushDecorator constructor.
     * @param EventDispatcherInterface $next
     * @param EntityManagerInterface   $entityManager
     */
    public function __construct(EventDispatcherInterface $next, EntityManagerInterface $entityManager)
    {
        $this->next = $next;
        $this->entityManager = $entityManager;
    }

    /**
     * @param object $event
     * @return object
     */
    public function dispatch(object $event): object
    {
        $response = $this->next->dispatch($event);

        $this->entityManager->flush();

        return $response;
    }
}
