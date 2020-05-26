<?php

namespace App\Entity;

use App\Repository\MatchTrackerRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity=team::class, inversedBy="hometeamMatches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $homeTeams;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $awayTeam;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsMatchPlayed;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomeTeams(): ?team
    {
        return $this->homeTeams;
    }

    public function setHomeTeams(?team $homeTeams): self
    {
        $this->homeTeams = $homeTeams;

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
