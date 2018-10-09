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
        //echo "Querry";
        //die;
        $apiKey = "2b12bb84";
        $query ="monono";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?s=tron&apikey=' . $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $json = json_decode(curl_exec($ch));



        foreach ($json->Search as $movie){
            $ID =$movie->imdbID;
            $newloop = curl_init();
            curl_setopt($newloop, CURLOPT_URL, 'http://www.omdbapi.com/?i='.$ID.'&apikey=' . $apiKey);
            curl_setopt($newloop,  CURLOPT_RETURNTRANSFER, true);

        }

        $jsontest = json_decode(curl_exec($newloop));
        var_dump($jsontest);


        return $this->render('film/index.html.twig', [
            'controller_name' => "test",
           'query' => $query,
           'liste' => $json->Search,

        ]);
    }

    /**
     * @Route("/film_avec_parametres/{query}", name="Film avec paramètre")
     */
    public function affichageFilmavecParametres($query)
    {
        //echo "Querry";
        //die;
        $apiKey = "2b12bb84";
        //$query ="monono";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?s='. $query .'&apikey='. $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $json = json_decode(curl_exec($ch));



        foreach ($json->Search as $movie){
            $ID =$movie->imdbID;
            $newloop = curl_init();
            curl_setopt($newloop, CURLOPT_URL, 'http://www.omdbapi.com/?i='.$ID.'&apikey=' . $apiKey);
            curl_setopt($newloop,  CURLOPT_RETURNTRANSFER, true);

        }

        $jsontest = json_decode(curl_exec($newloop));
        var_dump($jsontest);


        return $this->render('film/index.html.twig', [
            'controller_name' => "test",
            'query' => $query,
            'liste' => $json->Search,

        ]);
    }



}
