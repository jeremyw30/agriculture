<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface):Response
    {
        $user = new User();
                $form = $this->createForm(RegisterUserType::class, $user);
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()){
                    $user = $form->getData();
                    $user->setRoles(['ROLE_USER']);
                    $user->setCreatedAt(new \DateTimeImmutable());
                    $user->setBalance(100000);
                    //figer les don
                    $entityManagerInterface->persist($user);
                    //envoyer les données
                    $entityManagerInterface->flush();
        
                }
                return $this->render('register/index.html.twig',['form' => $form->createView()
    ]);
            }
}
