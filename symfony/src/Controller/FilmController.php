<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FilmController extends AbstractController
{
    /**
     * @Route("/", name="Home")
     */
    public function query()
    {
        //echo "Querry";
        //die;
        $apiKey = "2b12bb84";
        $query ="star";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?s='.$query.'&apikey=' . $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $json = json_decode(curl_exec($ch));



        foreach ($json->Search as $movie){
            $ID =$movie->imdbID;
            $newloop = curl_init();
            curl_setopt($newloop, CURLOPT_URL, 'http://www.omdbapi.com/?i='.$ID.'&apikey=' . $apiKey);
            curl_setopt($newloop,  CURLOPT_RETURNTRANSFER, true);
        }

        $jsontest = json_decode(curl_exec($newloop));

        return $this->render('film/index.html.twig', [
            'controller_name' => "test",
           'query' => $query,
           'liste' => $json->Search,

        ]);
    }

    /**
     * @Route("/film_avec_parametres/{query1}", name="Film avec paramètre")
     */
    public function affichageFilmavecParametres($query1)
    {
        $apiKey = "2b12bb84";
        //$query1 ="pirate";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?s='. $query1 .'&apikey='. $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $json = json_decode(curl_exec($ch));

        foreach ($json->Search as $movie){
            $ID =$movie->imdbID;
            $newloop = curl_init();
            curl_setopt($newloop, CURLOPT_URL, 'http://www.omdbapi.com/?i='.$ID.'&apikey=' . $apiKey);
            curl_setopt($newloop,  CURLOPT_RETURNTRANSFER, true);
        }

        $jsontest = json_decode(curl_exec($newloop));

        /*if (isset($jsontest->Search)){
            return $this->render('film/index.html.twig', [
                'query' => $,
                'liste' => $json->Search,
    
            ]);
        }else{
            return $this->render('film/notFound.html.twig', [
                'liste' => $json->Search,
    
            ]);
        }*/
        
        return $this->render('film/index.html.twig', [
            'liste' => $json->Search,

        ]);
    }

    /**
     * @Route("/film_select/{link}", name="FilmSelectionne")
     */
    public function affichageFilmSelectionne($link)
    {
        $apiKey = "2b12bb84";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?i='. $link .'&apikey='. $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $json = json_decode(curl_exec($ch));

        
        return $this->render('film/filmSelect.html.twig', [
            'film' => $json

        ]);
    }

    /**
     * @Route(
     * "/recherche", 
     * name="rechercheFilm"
     * )
     */
    public function rechercheFilm(request $request)
    {
        //analyser le contenu de l'objet request
        //dump ($request->query->get('title'));
        //die;
        $query = $request->query->get('title');
        /*$apiKey = "2b12bb84";

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
        
        return $this->render('film/index.html.twig', [
            'liste' => $json->Search,
        ]);*/

        //redirection vers l'action du controleur qui va afficher la liste des films avec ce parametre -> ne fonctionne pas prob avec la route 
        return $this->redirectToRoute(
            'Film avec paramètre',
            array(
                'query1' => $request->query->get('title')
            )
            );

    }

    /**
     * @Route(
     * "/detailsFilm/{idFilm}}", 
     * name="ficheDetailleeMail"
     * )
     */
    public function detailsFilm($idFilm)
    {
        //analyser le contenu de l'objet request
        dump ($request->request->all());
        die;

        /*$idFilm = $request->request->get('imdbId');
        
        $apiKey = "2b12bb84";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?i='. $idFilm .'&apikey='. $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $json = json_decode(curl_exec($ch));

        if (isset ($json->Response) && $json->Response == "False"){
            return $this->render('film/notFound.html.twig');
        }
        else{
            return $this->render('mail/email.html.twig', [
                'film' => $json
            ]);
        }*/
    }

    /**
     * @Route(
     * "/partage", 
     * name="partage"
     * )
     */
    public function partagePOST(request $request, \Swift_Mailer $maileur)
    {
       //analyser le contenu de l'objet request
        //dump ($request->request->all());
        //die;

        $idFilm = $request->request->get('imdbId');
        $email = $request->request->get('adresseMail');

        $apiKey = "2b12bb84";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.omdbapi.com/?i='. $idFilm .'&apikey='. $apiKey);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

        $json = json_decode(curl_exec($ch));

        if (isset ($json->Response) && $json->Response == "False"){
            return $this->render('film/notFound.html.twig');
        }
        else{
            $output = $this->render('mail/email.html.twig',
            array(
                'film' => $json
            )
            );

            //creation d'un objet swift message
            $message = (new \Swift_Message('Un super utilisateur veut partager avec vous un film ouf guedin : '))
                ->setFrom('bruceLee@jardinZen.fr')
                ->setTo( $email )
                ->setBody(
                    $output,
                    'text/html'
                );
            
            //appel du facteur et envoi
            $maileur->send($message);

            //ajout d'un msg de confirmation
            $this->addFlash(
                'success',
                'Message envoyé avec succés. Bravo champion !'
            );


            return $this->redirectToRoute(
                'FilmSelectionne',
                array(
                    'link' => $idFilm
                )
                );

        }
    }

}
