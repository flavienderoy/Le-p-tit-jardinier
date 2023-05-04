<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Haie;
use App\Entity\User;
use App\Entity\Devis;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DevisController extends AbstractController
{
    #[Route('/devis', name: 'app_devis')]
    public function index(SessionInterface $session, ManagerRegistry $doctrine): Response  
    {
        $request = Request::createFromGlobals();
        
        $session = new Session();                   // On créer une session pour garder les données saisies auparavant 
                                                    // Chaque page a besoin donc de la session

        $choix= $session->get('choix');             // On utilise les get pour obtenir les données de l'id de l'input voulue
        $haie=$request->get('haie');
        $hauteur=$request->get('hauteur');
        $longueur=$request->get('longueur');
        if (!empty($this->getUser())) {
            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));

            $typeClient = $monUser->getTypeClient();
        } else {
            $typeClient = '';
        }

        $session->set('monUser', $monUser);

        $type= $session->set('haie', $haie);
        $hauteursession= $session->set('hauteur', $hauteur);
        $longueursession= $session->set('longueur', $longueur);


        $prix = $doctrine->getRepository(Haie::class)->find($haie)->getPrix();

        $maHaie = $doctrine->getRepository(Haie::class)->find($haie);


        return $this->render('devis/index.html.twig', [          // Envoyer à la vue 
            'controller_name' => 'DevisController', 
            'choix' => $choix,
            'maHaie' => $maHaie,
            'hauteur' => $hauteur,
            'longueur' => $longueur,
            'prix' => $prix,
            'haie' => $haie,
            'typeClient' => $typeClient,
        ]);
    }
}
