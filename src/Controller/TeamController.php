<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Form\CreateTeamForm;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    /**
     * @Route("/team", name="team")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $form = $this->createForm(CreateTeamForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team = new Team();
            $team->setTeamName($form->get('teamName')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $user->setTeam($team);
            $entityManager->persist($team);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute("team_homepage");
        }

        return $this->render('team/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'TeamController',
        ]);
    }


}
