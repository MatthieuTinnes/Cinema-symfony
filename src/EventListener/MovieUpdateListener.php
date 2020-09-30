<?php


namespace App\EventListener;
use App\Entity\Movie;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class MovieUpdateListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    // the entity listener methods receive two arguments:
    // the entity instance and the lifecycle event
    public function postPersist(Movie $movie, LifecycleEventArgs $event)
    {
        $this->logger->info("Film : " . $movie->getTitle() . " updated");
    }

}