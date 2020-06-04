<?php

namespace App\Controller;

use App\Entity\Match;
use App\Entity\MatchTracker;
use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WinnerController extends AbstractController
{
    /**
     * @Route("/winner/{MatchTracker}", name="winner")
     * @param MatchTracker $MatchTracker
     * @return Response
     */
    public function index(MatchTracker $MatchTracker)
    {
        $em = $this->getDoctrine()->getManager();
        $POINTSPERWIN = 3;
        $POINTSPERLOSE = 0;
        $POINTSPERTIE = 1;
        $playedMatch = new Match();

        $winnerTeam = $_POST['winner'] ?? "tie";



        if (!isset($_POST['tie'])){
            $winningTeam = $this->getDoctrine()->getRepository(Team::class)
                ->findOneBy(['teamName' => $winnerTeam]);
            $playedMatch->setWinner($winningTeam);
            $winningTeam->setScore($winningTeam->getScore() + $POINTSPERWIN);
            $em->persist($winningTeam);
        }
        if ($MatchTracker->getRound() != 0){

            $nextMatchTracker = new MatchTracker();
            $nextMatchTracker->setHomeTeam($winningTeam);
            $nextMatchTracker->setAwayTeam($winningTeam);
            $nextMatchTracker->setIsMatchPlayed(0);
            $nextMatchTracker->setRound(2);
            $em->persist($nextMatchTracker);

        }
        if ($winnerTeam == "tie") {
            $playedMatch->setTie(true);
            $MatchTracker->getAwayTeam()->setScore($MatchTracker->getAwayTeam()->getScore() + $POINTSPERTIE);
            $MatchTracker->getHomeTeam()->setScore($MatchTracker->getHomeTeam()->getScore() + $POINTSPERTIE);
            $em->persist($MatchTracker->getAwayTeam());
            $em->persist($MatchTracker->getHomeTeam());



        } elseif ($MatchTracker->getHomeTeam()->getTeamName() == $winnerTeam) {

            $losingTeam = $this->getDoctrine()->getRepository(Team::class)
                ->findOneBy(['teamName' => $MatchTracker->getAwayTeam()->getTeamName()]);
            $playedMatch->setLoser($losingTeam);
            $em->persist($losingTeam);

        } else {

            $losingTeam = $this->getDoctrine()->getRepository(Team::class)
                ->findOneBy(['teamName' => $MatchTracker->getHomeTeam()->getTeamName()]);
            $playedMatch->setLoser($losingTeam);
            $em->persist($losingTeam);
        }

        $MatchTracker->setIsMatchPlayed(true);
        //TODO: find way to identify loser
        $em->persist($playedMatch);
        $em->flush();
        return $this->redirectToRoute('tournament');
    }
}
