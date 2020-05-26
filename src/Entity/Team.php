<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $teamName;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="team")
     */
    private $members;

    /**
     * @ORM\ManyToMany(targetEntity=Match::class, mappedBy="teams")
     */
    private $matches;

    /**
     * @ORM\OneToMany(targetEntity=Match::class, mappedBy="winner")
     */
    private $matchesWon;

    /**
     * @ORM\OneToMany(targetEntity=Match::class, mappedBy="loser")
     */
    private $matchesLost;

    /**
     * @ORM\OneToMany(targetEntity=MatchTracker::class, mappedBy="homeTeams")
     */
    private $hometeamMatches;


    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->matches = new ArrayCollection();
        $this->matchesWon = new ArrayCollection();
        $this->matchesLost = new ArrayCollection();
        $this->hometeamMatches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): self
    {
        $this->teamName = $teamName;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setTeam($this);
        }

        return $this;
    }

    public function removeMember(User $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getTeam() === $this) {
                $member->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Match[]
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Match $match): self
    {
        if (!$this->matches->contains($match)) {
            $this->matches[] = $match;
            $match->addTeam($this);
        }

        return $this;
    }

    public function removeMatch(Match $match): self
    {
        if ($this->matches->contains($match)) {
            $this->matches->removeElement($match);
            $match->removeTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection|Match[]
     */
    public function getMatchesWon(): Collection
    {
        return $this->matchesWon;
    }

    public function addMatchesWon(Match $matchesWon): self
    {
        if (!$this->matchesWon->contains($matchesWon)) {
            $this->matchesWon[] = $matchesWon;
            $matchesWon->setWinner($this);
        }

        return $this;
    }

    public function removeMatchesWon(Match $matchesWon): self
    {
        if ($this->matchesWon->contains($matchesWon)) {
            $this->matchesWon->removeElement($matchesWon);
            // set the owning side to null (unless already changed)
            if ($matchesWon->getWinner() === $this) {
                $matchesWon->setWinner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Match[]
     */
    public function getMatchesLost(): Collection
    {
        return $this->matchesLost;
    }

    public function addMatchesLost(Match $matchesLost): self
    {
        if (!$this->matchesLost->contains($matchesLost)) {
            $this->matchesLost[] = $matchesLost;
            $matchesLost->setLoser($this);
        }

        return $this;
    }

    public function removeMatchesLost(Match $matchesLost): self
    {
        if ($this->matchesLost->contains($matchesLost)) {
            $this->matchesLost->removeElement($matchesLost);
            // set the owning side to null (unless already changed)
            if ($matchesLost->getLoser() === $this) {
                $matchesLost->setLoser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MatchTracker[]
     */
    public function getHometeamMatches(): Collection
    {
        return $this->hometeamMatches;
    }

    public function addHometeamMatch(MatchTracker $hometeamMatch): self
    {
        if (!$this->hometeamMatches->contains($hometeamMatch)) {
            $this->hometeamMatches[] = $hometeamMatch;
            $hometeamMatch->setHomeTeam($this);
        }

        return $this;
    }

    public function removeHometeamMatch(MatchTracker $hometeamMatch): self
    {
        if ($this->hometeamMatches->contains($hometeamMatch)) {
            $this->hometeamMatches->removeElement($hometeamMatch);
            // set the owning side to null (unless already changed)
            if ($hometeamMatch->getHomeTeam() === $this) {
                $hometeamMatch->setHomeTeam(null);
            }
        }

        return $this;
    }

}
