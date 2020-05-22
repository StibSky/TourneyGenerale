<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class TeamHomepageController extends AbstractController
{
    /**
     * @Route("/team/homepage", name="team_homepage")
     * @param UserInterface $user
     * @return Response
     */
    public function index(UserInterface $user)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findBy(
            ['team' => null]
        );

        $loggedInUser = $this->getUser();



        return $this->render('team_homepage/index.html.twig', [
            'controller_name' => 'TeamHomepageController',
            'users' => $users,
        ]);
    }
}
