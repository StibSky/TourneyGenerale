<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamHomepageController extends AbstractController
{
    /**
     * @Route("/team/homepage", name="team_homepage")
     * @return Response
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findBy(
            ['team' => null]
        );

        return $this->render('team_homepage/index.html.twig', [
            'controller_name' => 'TeamHomepageController',
            'users' => $users,
        ]);
    }
}
