<?php
namespace App\Controller;

use App\Entity\Category;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;
class MovieController extends AbstractController
{
    /**
    * @Route("/movies")
    */
    public function movies(MovieRepository $movieRepository)
    {
        $movies = $movieRepository->getMovies();

        return $this->render('movies.html.twig', [
            'movies' =>$movies,
        ]);
    }
    /**
     * @Route("/movie/{id}")
     */
    public function movieDetail($id)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->find($id);

        return $this->render('movieDetail.html.twig', [
            'movie' =>$movie,
        ]);
    }

    /**
     * @Route("/category/{id}")
     */
    public function moviesByCategory(MovieRepository $movieRepository, $id)
    {
        $category = $movieRepository->getMoviesByCategory($id);

        return $this->render('movies.html.twig', [
            'movies' =>$category,
        ]);
    }
}