<?php

namespace App\Controller;

use App\Entity\Match;
use Proxies\__CG__\App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LadderController extends AbstractController
{
    /**
     * @Route("/ladder", name="ladder")
     */

    public function index()
    {
        $CUT64 = 64;
        $CUT32 = 32;
        $CUT16 = 16;
        $CUT8 = 8;
        $CUT4 = 4;
        $CUT2 = 2;
        $topArray = [];

        $em = $this->getDoctrine()->getManager();

        $allTeams = $this->getDoctrine()->getRepository(\App\Entity\Team::class)->findAll();
        $numberOfTeams = count($allTeams);

        $ladder = $em->getRepository(\App\Entity\Team::class)->findBy(array(), array('score' => 'ASC'));

        switch (true) {
            case ($numberOfTeams >= $CUT64):
                $topArray = array_slice($ladder, (count($ladder))-$CUT64);
                break;
            case ($numberOfTeams >= $CUT32):
                $topArray = array_slice($ladder, (count($ladder))-$CUT32);
                break;
            case ($numberOfTeams >= $CUT16):
                $topArray = array_slice($ladder, (count($ladder))-$CUT16);
                break;
            case ($numberOfTeams >= $CUT8):
                $topArray = array_slice($ladder, (count($ladder))-$CUT8);
                break;
            case ($numberOfTeams >= $CUT4):
                $topArray = array_slice($ladder, (count($ladder))-$CUT4);
                break;
            case ($numberOfTeams >= $CUT2):
                $topArray = array_slice($ladder, (count($ladder))-$CUT2);
                break;
        }

        $bracketArray = $topArray;

        $firstHalfBracket = array_splice($bracketArray, (count($topArray)/2));
        $secondHalfBracket = $bracketArray;
        shuffle($firstHalfBracket);
        shuffle($secondHalfBracket);


        return $this->render('ladder/index.html.twig', [
            'ladder' => $ladder,
            'topTeams' => array_reverse($topArray),
            'firstHalf' => $firstHalfBracket,
            'secondHalf' => $secondHalfBracket,
        ]);
    }
}
