<?php

namespace App\Controller;

use App\Entity\Match;
use App\Entity\MatchTracker;
use App\Entity\Team;
use App\Entity\Tournament;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    /**
     * @Route("/tournament", name="tournament")
     */


    public function index()
    {
        $allteams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        $numberOfMatchesInRound = count($allteams)/2;
        foreach ($allteams as $team)  {
            $team->getId();
        }
        $secondRoundTeams = $this->getDoctrine()->getRepository(MatchTracker::class)
            ->findBy(['round' => 1]);



        return $this->render('tournament/index.html.twig', [
            'numberofMatchesinRound' => $numberOfMatchesInRound,
            'firstRound' => $this->getDoctrine()->getRepository(MatchTracker::class)->findBy(['round' => 1, 'IsMatchPlayed' => false]),
            'roundTwo' => $this->getDoctrine()->getRepository(MatchTracker::class)->findBy(['round' => 2, 'IsMatchPlayed' => false]),
        ]);
    }

}
