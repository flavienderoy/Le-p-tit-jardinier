<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\User;
use App\Entity\Devis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\nomClasseMetier;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Haie;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\Session\Session;

class CreationDevisController extends AbstractController
{
    #[Route('/creation/devis', name: 'app_creation_devis')]
    public function index(ManagerRegistry $doctrine, SessionInterface $session, Request $request): Response
    {

        $request = Request::createFromGlobals();

        $entityManager = $doctrine->getManager();

        $choix = $session->get('choix');             // On utilise les get pour obtenir les données de l'id de l'input voulue
        $haie = $session->get('haie');
        $hauteur = $session->get('hauteur');
        $longueur = $session->get('longueur');

        if (!empty($this->getUser())) {
            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));

            $typeClient = $monUser->getTypeClient();
        } else {
            $typeClient = '';
        }

        $codehaie = $doctrine->getRepository(Haie::class)->find($haie);

        $devis = new Devis();
        $devis->setUser($monUser);
        $devis->setHaie($codehaie);
        $devis->setLongueur($longueur);
        $devis->setHauteur($hauteur);
        $devis->setDate(new \DateTime());

        $entityManager->persist($devis);
        $entityManager->flush();


        return $this->render('creation_devis/index.html.twig', [
            'controller_name' => 'CreationDevisController',
            'user' => $monUser,
        ]);
    }
}
