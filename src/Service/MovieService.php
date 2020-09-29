<?php


namespace App\Service;
use App\Entity\Category;
use App\Entity\Person;
use App\Repository\CategoryRepository;
use App\Repository\PersonRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Movie;
use Symfony\Flex\Path;

class MovieService
{
    private $client;
    private $context;
    private $apiKey;
    private $categoryRepository;
    private $personRepository;
    private $entityManager;

    public function __construct($apiKey,CategoryRepository $categoryRepository, PersonRepository $personRepository, EntityManagerInterface $entityManager)
    {
        $this->client = HttpClient::create();
        $this->categoryRepository = $categoryRepository;
        $this->personRepository = $personRepository;
        $this->apiKey = $apiKey;
        $this->entityManager = $entityManager;
    }
    public function generateRandomFilm(){
        $movie = new Movie();
        do {
            $id = random_int(1000, 748076);
            $response = $this->client->request(
                'GET',
                "https://api.themoviedb.org/3/movie/$id?api_key=$this->apiKey&language=en-US"
            );
            $statusCode = $response->getStatusCode();
        }while($statusCode !=200);
        $content = $response->toArray();
        $movie->setTitle($content['title']);
        $movie->setDescription($content['overview']);
        $date = DateTime::createFromFormat("Y-m-d",$content['release_date']);
        if(!$date){
            $date = null;
        }
        $movie->setReleaseDate($date);
        $category = $this->categoryRepository->find(1);
        $movie->setRealisator($this->personRepository->find(1));
        $movie->setCategory($category);
        if(!empty($content['poster_path']))
            $movie->setImagePath("https://image.tmdb.org/t/p/w500/".$content['poster_path']);
        $this->entityManager->persist($movie);
        $this->entityManager->flush();
    }

}