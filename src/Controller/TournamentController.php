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
    //all the answers talk about constructors


    public function index()
    {
        $allteams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        $matchTracker = new MatchTracker();
        $hometeam = $matchTracker->getHomeTeam();
        $awayteam = $matchTracker->getAwayTeam();
        $matchTrackerssss = new Tournament();

        //round robin
        //randomly match teams


/*        $array = [1,2,3,4,5,6,7,8,9,10];
        $round1 = $array[1] vs 2846;
        $round2 = $array[3] vs 468;
        $round3 = $array[5] vs 68;
        $round4 = $array[7] vs 8;

        $round6 = $array[2] vs 375;
        $round7 = $array[4] vs 57;
        $round8 = $array[6] vs 7;

        $round9 = $array[1]vs 357;
        $round10 = $array[3] vs 57;
        $round11 = $array[5] vs 7;

        $round12 = $array[2] vs 468;
        $round13 = $array[4] vs 68;
        $round14 = $array[6] vs 8;*/

        $numberOfMatchesInRound = count($allteams)/2;
        $entityManager = $this->getDoctrine()->getManager();


        function roundRobin($allteams, $entityManager)
        {
            $away = array_splice($allteams,(count($allteams)/2));
            $home = $allteams;

            if (count($allteams)%2 != 0){
                array_push($allteams, new Team());
            }

            for ($i=0; $i < count($home)+count($away)-1; $i++){
                for ($j=0; $j<count($home); $j++){
                    $newMatchTracker = new MatchTracker();
                    $newMatchTracker->setAwayTeam($away[$j]);
                    $newMatchTracker->setHomeTeam($home[$j]);
                    $newMatchTracker->setIsMatchPlayed("false");
                    $entityManager->persist($newMatchTracker);
                }
                if(count($home)+count($away)-1 > 2){
                    $splicedHomeArray = array_splice($home,1,1);
                    array_unshift($away,array_shift($splicedHomeArray));
                    array_push($home,array_pop($away));
                }
            }
        }

        roundRobin($allteams, $entityManager);
        $entityManager->flush();


        return $this->render('tournament/index.html.twig', [
            'controller_name' => 'TournamentController',
        ]);
    }
}
