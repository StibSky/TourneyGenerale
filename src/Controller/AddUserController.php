<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddUserController extends AbstractController
{
    /**
     * @Route("/add/user/{user}", name="add_user")
     * @param User $user
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(User $user, EntityManagerInterface $em)
    {
        $loggedInUser = $this->getUser();

        $user->setTeam($loggedInUser->getTeam());

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('team_homepage');
    }
}
