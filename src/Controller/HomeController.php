<?php
namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class HomeController extends AbstractController
{
    /**
     * @Route("/home")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function index(MovieRepository $movieRepository)
    {
        $movies = $movieRepository->findBy(array(),
            ['releaseDate' => 'DESC'],3);
        return $this->render('home.html.twig', [
            'movies' =>$movies,
        ]);
    }
}