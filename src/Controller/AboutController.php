<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    /**
    * @Route("/about")
    */
    public function about()
    {
        $authors = ["Corentin","Gribouille","Léa","Bastien"];
        return $this->render('about.html.twig', [
            'authors' => $authors,
        ]);
    }
}