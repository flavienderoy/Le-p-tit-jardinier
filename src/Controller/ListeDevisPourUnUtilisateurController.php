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

class ListeDevisPourUnUtilisateurController extends AbstractController
{
    #[Route('/liste/devis/pour/un/utilisateur', name: 'app_liste_devis_pour_un_utilisateur')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $mail = $this->getUser()->getUserIdentifier();
        $monUser = new User;
        $monUser = $doctrine->getRepository(User::class)->findOneBy(['email' => $mail]);

        $devisRepository = $doctrine->getRepository(Devis::class);

        $listeDevis = $devisRepository->findBy(array('user' => $monUser));


        return $this->render('liste_devis_pour_un_utilisateur/index.html.twig', [
            'controller_name' => 'ListeDevisPourUnUtilisateurController',
            'listeDevis' => $listeDevis,
            'monUser' => $monUser,
        ]);
    }
}
