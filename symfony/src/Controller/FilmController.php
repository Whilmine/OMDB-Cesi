<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    /**
     * @Route("/query", name="Query")
     */
    public function query()
    {
        echo "Querry";
        die;

        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
        ]);
    }
}
