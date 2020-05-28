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
        $winnerTeam = $_POST['winner'];
        $winningTeam = $this->getDoctrine()->getRepository(Team::class)
            ->findOneBy(['teamName' => $winnerTeam]);
        $playedMatch = new Match();
        $playedMatch->setWinner($winningTeam);
        if ($winnerTeam == "tie") {
            $playedMatch->setTie(true);

        } elseif ($MatchTracker->getHomeTeam()->getTeamName() == $winnerTeam) {
            $losingTeam = $this->getDoctrine()->getRepository(Team::class)
                ->findOneBy(['teamName' => $MatchTracker->getAwayTeam()->getTeamName()]);
            $playedMatch->setLoser($losingTeam);

        } else {
            $losingTeam = $this->getDoctrine()->getRepository(Team::class)
                ->findOneBy(['teamName' => $MatchTracker->getHomeTeam()->getTeamName()]);
            $playedMatch->setLoser($losingTeam);
        }


        //TODO: find way to identify loser
        $em = $this->getDoctrine()->getManager();
        $em->persist($playedMatch);
        $em->flush();
        return $this->redirectToRoute('tournament');
    }
}
