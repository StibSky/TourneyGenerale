<?php

namespace App\Controller;

use App\Entity\MatchTracker;
use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    /**
     *@Route("/tournament", name="tournament")
     */
    //all the answers talk about constructors

    private $allteams;
  /*  private $hometeams = new MatchTracker();
    private $hometeam = $hometeams->getHomeTeams();
    private $awayteams = new MatchTracker();
    private $awayteam = $awayteams->getAwayTeam();*/

//    public function __construct()
//    {
//        $this->allteams = $this->getDoctrine()->getRepository(Team::class)->findAll();
//    }

    public function index()
    {
        //round robin
        //randomly match teams
        //$this->allteams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        var_dump($this->allteams);

//
//        function roundRobin($allteams){
//            $this->allteams->getDoctrine()->getRepository(Team::class)->findAll();
//        }
//        roundRobin($this->allteams);
//

        return $this->render('tournament/index.html.twig', [
            'controller_name' => 'TournamentController',
        ]);
    }
}
