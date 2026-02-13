<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#
final class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(
        UserRepository $userRepository): Response
    {

        $users = $userRepository->findAll();

        return $this->render('inscription/inscription.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/inscription/{id}', name: 'app_inscription_show')]
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
    public function showUser(UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return $this->render('inscription/show.html.twig', [
            'user' => $user,
        ]);
    }


}
