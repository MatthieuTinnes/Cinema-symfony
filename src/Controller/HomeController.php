<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Person;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class HomeController extends AbstractController
{
    /**
     * @Route("/home",name="home")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function index(MovieRepository $movieRepository)
    {
        $movies = $movieRepository->get3LastMovie();
        return $this->render('home.html.twig', [
            'movies' =>$movies,
        ]);
    }

    /**
     * @Route("/categoryRender")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function categoryRender(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository
            ->findAll();

        return $this->render('footer.html.twig', [
            'categories' =>$categories,
        ]);
    }
}