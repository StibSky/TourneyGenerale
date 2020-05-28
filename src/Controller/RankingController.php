<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RankingController extends AbstractController
{
    /**
     * @Route("/ranking", name="ranking")
     */
    public function index()
    {
        $teams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        foreach ($teams as $team){
            $pointsArray[] = [
                'score' => $team->getScore(),
                'name' => $team->getTeamName()
            ];
        }
        rsort($pointsArray);


        return $this->render('ranking/index.html.twig', [
            'sortedArray' => $pointsArray,
        ]);
    }
}
