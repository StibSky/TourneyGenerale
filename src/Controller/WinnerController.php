<?php

namespace App\Controller;

use App\Entity\Match;
use App\Entity\Team;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WinnerController extends AbstractController
{
    /**
     * @Route("/winner/{team}", name="winner")
     * @param Team $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Team $team)
    {
        $winner = $team;
        $winnerteam = new Match();


        return $this->render('winner/index.html.twig', [
            'controller_name' => 'WinnerController'
        ]);
    }
}
