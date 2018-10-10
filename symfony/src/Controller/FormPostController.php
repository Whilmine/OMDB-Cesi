<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FormPostController extends AbstractController
{
    /**
     * @Route("/form/post", name="form_post")
     */
    public function index()
    {
        return $this->render('form_post/index.html.twig', [
            'controller_name' => 'FormPostController',
        ]);
    }
}
