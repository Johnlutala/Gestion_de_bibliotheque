<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/inscription', name: 'app_inscription_')]
final class InscriptionController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        UserRepository $userRepository): Response
    {

        $users = $userRepository->findAll();

        return $this->render('inscription/inscription.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return $this->render('inscription/show.html.twig', [
            'user' => $user,
        ]);
    }



    #[Route('/inscription', name: 'new')]
    public function showUser(
         User $user, UserRepository $userRepository, \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $passwordHasher, \Doctrine\ORM\EntityManagerInterface $em,
        UserRepository $userRepository, int $id): Response
    {
       $user=new User();
       $form=$this->createForm(User::class,$user);
       $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }
            $em->persist($user);
            $em->flush();
        }

        return $this->render('inscription/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


