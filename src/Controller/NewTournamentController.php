<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Form\TournamentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewTournamentController extends AbstractController
{

    /**
     * @Route("/new/tournament", name="new_tournament")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        $form = $this->createForm(TournamentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tournament = new Tournament();
            $tournament->setName($form->get('name')->getData());
            $tournament->setType($form->get('type')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tournament);
            $entityManager->flush();
            return $this->redirectToRoute("team_homepage");
        }

        return $this->render('new_tournament/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'NewTournamentController',
        ]);
    }
}
