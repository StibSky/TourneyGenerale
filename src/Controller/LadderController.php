<?php

namespace App\Controller;

use App\Entity\Match;
use App\Entity\MatchTracker;
use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LadderController extends AbstractController
{
    /**
     * @Route("/ladder", name="ladder")
     */
    public function index()
    {
        $topArray = [];
        $cuts = [64, 32, 16, 8, 4, 2];

        $em = $this->getDoctrine()->getManager();

        $allTeams = $this->getDoctrine()->getRepository(\App\Entity\Team::class)->findAll();
        $numberOfTeams = count($allTeams);

        $ladder = $em->getRepository(\App\Entity\Team::class)->findBy(array(), array('score' => 'ASC'));

        foreach ($cuts as $cut) {
            if ($numberOfTeams >= $cut) {
                $topArray = array_slice($ladder, (count($ladder)) - $cut);
                break;
            }
        }
        $numberOfRound0 = count($this->getDoctrine()->getRepository(MatchTracker::class)
            ->findBy(['round' => 0]));
        $numberOfPlayed0 = count($this->getDoctrine()->getRepository(MatchTracker::class)
            ->findBy(['round' => 0, 'IsMatchPlayed' => 1]));

        if (
            $numberOfRound0 == $numberOfPlayed0 && $numberOfPlayed0 != 0
            && !$this->getDoctrine()->getRepository(MatchTracker::class)->findOneBy(['round' => 1])
        ) {
            $bracketArray = $topArray;
            $firstHalfBracket = array_splice($bracketArray, (count($topArray) / 2));
            $secondHalfBracket = $bracketArray;
            shuffle($firstHalfBracket);
            shuffle($secondHalfBracket);
            for ($i = 0; $i < count($firstHalfBracket); $i++) {
                $matchTracker = new MatchTracker();
                $matchTracker->setRound(1);
                $matchTracker->setHomeTeam($firstHalfBracket[$i]);
                $matchTracker->setAwayTeam($secondHalfBracket[$i]);
                $matchTracker->setIsMatchPlayed(false);
                $em->persist($matchTracker);
            }
            $em->flush();
        }


        return $this->render('ladder/index.html.twig', [
            'allRounds' => $this->getDoctrine()->getRepository(MatchTracker::class)->findBy(['IsMatchPlayed' => false, 'round' => 0]),
            'ladder' => array_reverse($ladder),
            'topTeams' => array_reverse($topArray),
            'bracket' => $this->getDoctrine()->getRepository(MatchTracker::class)
                ->findBy(['round' => 1])
        ]);
    }

    /**
     * @Route("/startRoundRobin", name="roundRobin")
     */

    public function roundRobin()
    {
        //so this is our problem

        if (count($this->getDoctrine()->getRepository(MatchTracker::class)->findAll()) !== 0) {
            return $this->redirectToRoute('tournament');
        }

        //To Do:
        //Figure out what to do with faketeam in the DB if a new team joins and we have even numbers again
        //

        $allteams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        $matchTracker = new MatchTracker();
        $entityManager = $this->getDoctrine()->getManager();

        if (count($allteams) % 2 != 0) {
            $fakeTeam = new Team();
            $fakeTeam->setTeamName("You have a bye");
            array_push($allteams, $fakeTeam);
            $entityManager->persist($fakeTeam);
        }

        $away = array_splice($allteams, (count($allteams) / 2));
        $home = $allteams;


        for ($i = 0; $i < count($home) + count($away) - 1; $i++) {
            for ($j = 0; $j < count($home); $j++) {
                $newMatchTracker = new MatchTracker();
                $newMatchTracker->setRound(0);
                $newMatchTracker->setAwayTeam($away[$j]);
                $newMatchTracker->setHomeTeam($home[$j]);
                if ($newMatchTracker->getAwayTeam()->getTeamName() == "You have a bye") {
                    $match = new Match();
                    $match->setWinner($newMatchTracker->getHomeTeam());
                    $newMatchTracker->setIsMatchPlayed(1);
                    $entityManager->persist($match);
                } elseif ($newMatchTracker->getHomeTeam()->getTeamName() == "You have a bye") {
                    $match = new Match();
                    $match->setWinner($newMatchTracker->getAwayTeam());
                    $newMatchTracker->setIsMatchPlayed(1);
                    $entityManager->persist($match);
                } else {
                    $newMatchTracker->setIsMatchPlayed(0);
                }
                $entityManager->persist($newMatchTracker);
            }
            if (count($home) + count($away) - 1 > 2) {
                $splicedHomeArray = array_splice($home, 1, 1);
                array_unshift($away, array_shift($splicedHomeArray));
                array_push($home, array_pop($away));
            }
        }
        $entityManager->flush();

        return $this->redirectToRoute('ladder');
    }
}
