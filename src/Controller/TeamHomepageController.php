<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeamHomepageController extends AbstractController
{
    /**
     * @Route("/team/homepage", name="team_homepage")
     */
    public function index()
    {

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('team_homepage/index.html.twig', [
            'controller_name' => 'TeamHomepageController',
            'users' => $users,
        ]);
    }
}
