<?php
namespace App\Controller;

use App\Entity\Category;
use App\form\type\MovieType;
use App\Repository\MovieRepository;
use App\Repository\PersonRepository;
use App\Service\MovieService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Movie;
class MovieController extends AbstractController
{
    /**
     * @Route("/movies",name="movieList")
     * @param MovieRepository $movieRepository
     * @return Response
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
     * @param MovieRepository $movieRepository
     * @param PersonRepository $personRepository
     * @param $id
     * @return Response
     */
    public function movieDetail(MovieRepository $movieRepository, PersonRepository $personRepository, $id)
    {
        $movie = $movieRepository->getMovieDetail($id);
        $casting = $movie->getCasting();

        return $this->render('movieDetail.html.twig', [
            'movie' =>$movie,
            'actors' =>$casting,
        ]);
    }

    /**
     * @Route("/category/{id}")
     * @param MovieRepository $movieRepository
     * @param $id
     * @return Response
     */
    public function moviesByCategory(MovieRepository $movieRepository, $id)
    {
        $category = $movieRepository->getMoviesByCategory($id);

        return $this->render('movies.html.twig', [
            'movies' =>$category,
        ]);
    }

    /**
     * @Route("/add_movie")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addMovie(Request $request){
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();
            return $this->redirectToRoute('movieList');
        }
        return $this->render('addMovie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add_random_movie")
     * @param MovieService $movieService
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addRandomMovie(MovieService $movieService, Request $request){
        $movieService->generateRandomFilm();
        return $this->redirectToRoute('movieList');
    }
}