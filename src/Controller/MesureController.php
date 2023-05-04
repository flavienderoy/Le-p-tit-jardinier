<?php

namespace App\Controller;

use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Haie;

class MesureController extends AbstractController
{
    #[Route('/mesure', name: 'app_mesure')]
    public function index(ManagerRegistry $doctrine): Response //  Doctrine permet de faire persister les objets (classe dans entity) avec la base de donnée avec les Repository qui comporte les méthodes qui instancie les variables PRIVATE de l'entité X dans la méthode dans Repository qui met automatiquement dans la bdd (ORM DOCTRINE)
    {       
        
        $request = Request::createFromGlobals();
        $choix=$request->get('choix');          // On instancie ce qu'on récupère dans radio choix 

        $mesHaies = $doctrine->getRepository(Haie::class)->findAll();           // on récupère les méthodes dans HaieRepository et on prend la méthode findAll()

        return $this->render('mesure/index.html.twig', [                        // Récupérer les variables toujours sous forme de tableau[]
            'controller_name' => 'MesureController',
            'mesHaies' => $mesHaies                                     // 'mesHaies' récupérer dans la vue / instancié la valeur dans la vue dans la variable $mesHaies
        ]);
    }
}
