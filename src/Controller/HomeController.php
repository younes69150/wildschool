<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Argonautes;
use App\Form\NomArgonauteType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArgonautesRepository;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager, ArgonautesRepository $repo): Response
    {
        $name = new Argonautes();
        $form = $this->createForm(NomArgonauteType::class, $name);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $repo->save($name, true);
            return $this->redirect('/home');
        }

        $names = $repo->findAll();
       

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'names' => $names
        ]);
    }
}
