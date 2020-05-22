<?php

namespace App\DataFixtures;

use App\Entity\Match;
use App\Entity\Team;
use App\Entity\Tournament;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user2 = new User();
        $team = new Team();
        $team2 = new Team();
        $match = new Match();
        $tournament = new Tournament();
        $user->setUsername("matthijs");
        $user->setEmail("matthijs@gmail.com");
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$KRo3zJhvdVincbY6PSktkA$WC1UQdcanV2UKHtHejXsHiWMPmILLhqg0+8krlL17zU');
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setTeam($team);


        $user2->setUsername("taloes");
        $user2->setEmail("taloes@gmail.com");
        $user2->setPassword('$argon2id$v=19$m=65536,t=4,p=1$fs9ZJLnTVdENKwKrN/pOmA$TBQv1Em2rbncCYOcux6M+hLQWNP3AhjwqBB29w+R1Ho');
        $user2->setRoles(["ROLE_USER"]);
        $user2->setTeam($team2);

        $team->setTeamName("matteam");
        $team2->setTeamName("taloes");


        $match->setLoser($team);
        $match->setWinner($team2);
        $match->setTie(false);

        $tournament->setName("taloes big football");
        $tournament->setType("ice-skating");

        $manager->persist($team);
        $manager->persist($team2);
        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($match);
        $manager->persist($tournament);

        $manager->flush();
    }
}
