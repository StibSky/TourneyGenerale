<?php

namespace App\Entity;

use App\Repository\MatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatchRepository::class)
 * @ORM\Table(name="`match`")
 */
class Match
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Team::class, inversedBy="matches")
     */
    private $teams;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="matchesWon")
     */
    private $winner;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="matchesLost")
     */
    private $loser;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $tie;

    /**
     * @ORM\ManyToOne(targetEntity=Tournament::class, inversedBy="matches")
     */
    private $tournament;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
        }

        return $this;
    }

    public function getWinner(): ?Team
    {
        return $this->winner;
    }

    public function setWinner(?Team $winner): self
    {
        $this->winner = $winner;
        $this->winner->setScore($this->winner->getScore()+3);
        return $this;
    }

    public function getLoser(): ?Team
    {
        return $this->loser;
    }

    public function setLoser(?Team $loser): self
    {
        $this->loser = $loser;
        $this->loser->setScore($this->loser->getScore()+0);
        return $this;
    }

    public function getTie(): ?bool
    {
        return $this->tie;
    }

    public function setTie(?bool $tie, MatchTracker $matchTracker): self
    {
        $this->tie = $tie;
        $matchTracker->getHomeTeam()->setScore($matchTracker->getHomeTeam()->getScore()+1);
        $matchTracker->getAwayTeam()->setScore($matchTracker->getAwayTeam()->getScore()+1);
        return $this;
    }


    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): self
    {
        $this->tournament = $tournament;

        return $this;
    }

}
