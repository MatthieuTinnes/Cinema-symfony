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
        $content = $this->getRandomFilmFromAPI();
        $crew = $this->getCrewForMovie($content['id']);
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
        if(array_key_exists('genres',$content)) {
            if (count($content['genres']) > 0) {
                $category = $content['genres'][0]['name'];
                if (!empty($category)) {
                    $categoryObj = $this->categoryRepository->findOneBy(['name' => $category]);
                    if (is_null($categoryObj)) {
                        $categoryObj = new Category();
                        $categoryObj->setName($category);
                        $this->entityManager->persist($categoryObj);
                    }
                    $movie->setCategory($categoryObj);
                }
            }
        }
        $this->addCastToMovie($crew, $movie);
        $this->addRealisatorToMovie($crew, $movie);

        $this->entityManager->persist($movie);
        $this->entityManager->flush();
    }

    private function getRandomFilmFromAPI(){
        do {
            $id = random_int(1000, 748076);
            $response = $this->client->request(
                'GET',
                "https://api.themoviedb.org/3/movie/$id?api_key=$this->apiKey&language=en-US"
            );
            $statusCode = $response->getStatusCode();
        }while($statusCode !=200);
        return $response->toArray();
    }

    private function getCrewForMovie($tmDBId){
        $response = $this->client->request(
            'GET',
            "https://api.themoviedb.org/3/movie/$tmDBId/credits?api_key=$this->apiKey&language=en-US"
        );
        $statusCode = $response->getStatusCode();
        return $response->toArray();
    }

    /**
     * @param array $crew
     * @param Movie $movie
     */
    private function addCastToMovie(array $crew, Movie $movie)
    {
        if (array_key_exists("cast", $crew)) {
            foreach ($crew["cast"] as $cast) {
                $nameSplit = explode(" ", $cast['name']);
                $firstName = $nameSplit[0];
                $actorObj = $this->personRepository->findOneBy(['firstName' => $firstName]);
                if (count($nameSplit) > 1) {
                    $lastName = $nameSplit[1];
                    $actorObj = $this->personRepository->findOneBy(['firstName' => $firstName, 'lastName' => $lastName]);
                }
                if (is_null($actorObj)) {
                    $actorObj = new Person();
                    $actorObj->setFirstName($firstName);
                    if (isset($lastName)) {
                        $actorObj->setLastName($lastName);
                    }
                    $this->entityManager->persist($actorObj);
                }

                $movie->addCasting($actorObj);
            }
        }
    }

    /**
     * @param array $crew
     * @param Movie $movie
     */
    private function addRealisatorToMovie(array $crew, Movie $movie): void
    {
        if (array_key_exists("crew", $crew)) {
            foreach ($crew["crew"] as $cast) {
                if ($cast['job'] == "Director") {
                    $nameSplit = explode(" ", $cast['name']);
                    $firstName = $nameSplit[0];
                    $actorObj = $this->personRepository->findOneBy(['firstName' => $firstName]);
                    if (count($nameSplit) > 1) {
                        $lastName = $nameSplit[1];
                        $actorObj = $this->personRepository->findOneBy(['firstName' => $firstName, 'lastName' => $lastName]);
                    }
                    if (is_null($actorObj)) {
                        $actorObj = new Person();
                        $actorObj->setFirstName($firstName);
                        if (isset($lastName)) {
                            $actorObj->setLastName($lastName);
                        }
                        $this->entityManager->persist($actorObj);
                    }
                    $movie->setRealisator($actorObj);
                }
            }

        }
    }

}