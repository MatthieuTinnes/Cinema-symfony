<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;
class MovieController extends AbstractController
{
    /**
    * @Route("/movies")
    */
    public function movies()
    {
        $movies = $this->getDoctrine()
        ->getRepository(Movie::class)
        ->findAll();

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
}