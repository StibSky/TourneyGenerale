<?php

namespace App\Entity;

use App\Repository\MatchTrackerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @ORM\Entity(repositoryClass=MatchTrackerRepository::class)
 */
class MatchTracker
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="hometeamMatches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $homeTeam;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $awayTeam;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsMatchPlayed;

/*    protected function getDoctrine(): ManagerRegistry
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application. Try running "composer require symfony/orm-pack".');
        }

        return $this->container->get('doctrine');
    }*/

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomeTeam(): ?Team
    {
        return $this->homeTeam;
    }

    public function setHomeTeam(?Team $homeTeam): self
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    public function getAwayTeam(): ?Team
    {
        return $this->awayTeam;
    }

    public function setAwayTeam(?Team $awayTeam): self
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    public function getIsMatchPlayed(): ?bool
    {
        return $this->IsMatchPlayed;
    }

    public function setIsMatchPlayed(bool $IsMatchPlayed): self
    {
        $this->IsMatchPlayed = $IsMatchPlayed;

        return $this;
    }
}
