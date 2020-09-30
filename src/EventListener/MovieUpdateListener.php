<?php


namespace App\EventListener;
use App\Entity\Movie;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($movie,   'json', [AbstractNormalizer::ATTRIBUTES => ['title','releaseDate','description','realisator']]);

        $this->logger->info("Film updated : " . $jsonContent );
    }

}