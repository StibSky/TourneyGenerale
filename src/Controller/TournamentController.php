<?php

namespace App\Controller;

use App\Entity\MatchTracker;
use App\Entity\Team;
use App\Entity\Tournament;
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

        return $this->render('tournament/index.html.twig', [
            'controller_name' => 'TournamentController',
            'numberofMatchesinRound' => $numberOfMatchesInRound,
            'allRounds' => $this->getDoctrine()->getRepository(MatchTracker::class)->findBy(['IsMatchPlayed' => false]),
        ]);
    }

    /**
     * @Route("/startRoundRobin", name="roundRobin")
     */

    public function roundRobin()
    {
        //so this is our problem

        if(count($this->getDoctrine()->getRepository(MatchTracker::class)->findAll()) !== 0){
            return $this->redirectToRoute('tournament');
        }

        //To Do:
        //Figure out what to do with faketeam in the DB if a new team joins and we have even numbers again
        //

        $allteams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        $matchTracker = new MatchTracker();
        $hometeam = $matchTracker->getHomeTeam();
        $awayteam = $matchTracker->getAwayTeam();
        $entityManager = $this->getDoctrine()->getManager();

        if (count($allteams)%2 != 0){
            $fakeTeam = new Team();
            $fakeTeam->setTeamName("You have a bye");
            array_push($allteams, $fakeTeam);
            $entityManager->persist($fakeTeam);
        }

        $away = array_splice($allteams,(count($allteams)/2));
        $home = $allteams;

        for ($i=0; $i < count($home)+count($away)-1; $i++){
            for ($j=0; $j<count($home); $j++){
                $newMatchTracker = new MatchTracker();
                $newMatchTracker->setAwayTeam($away[$j]);
                $newMatchTracker->setHomeTeam($home[$j]);
                $newMatchTracker->setIsMatchPlayed(0);
                $entityManager->persist($newMatchTracker);
            }
            if(count($home)+count($away)-1 > 2){
                $splicedHomeArray = array_splice($home,1,1);
                array_unshift($away,array_shift($splicedHomeArray));
                array_push($home,array_pop($away));
            }
        }
        $entityManager->flush();

        return $this->redirectToRoute('tournament');
    }

}
