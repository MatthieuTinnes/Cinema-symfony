<?php
namespace App\Controller;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{

    /**
     * @Route("/person/{id}")
     */
    public function personDetail($id)
    {
        $person = $this->getDoctrine()
            ->getRepository(Person::class)
            ->find($id);

        return $this->render('personDetail.html.twig', [
            'person' =>$person,
        ]);
    }
}