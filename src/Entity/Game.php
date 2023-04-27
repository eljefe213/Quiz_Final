<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Game_Id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\OneToOne(inversedBy: 'Game', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Score $Score_id = null;

    #[ORM\OneToMany(mappedBy: 'Game', targetEntity: GameQuestion::class)]
    private Collection $gameQuestions;

    public function __construct()
    {
        $this->gameQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getScoreId(): ?Score
    {
        return $this->Score_id;
    }

    public function setScoreId(Score $Score_id): self
    {
        $this->Score_id = $Score_id;

        return $this;
    }

    /**
     * @return Collection<int, GameQuestion>
     */

    public function getGameQuestions(): Collection
    {
        return $this->gameQuestions;
    }

    public function addGameQuestion(GameQuestion $gameQuestion): self
    {
        if (!$this->gameQuestions->contains($gameQuestion)) {
            $this->gameQuestions[] = $gameQuestion;
            $gameQuestion->setGame($this);
        }

        return $this;
    }

    public function removeGameQuestion(GameQuestion $gameQuestion): self
    {
        if ($this->gameQuestions->removeElement($gameQuestion)) {
            if ($gameQuestion->getGame() === $this) {
                $gameQuestion->setGame(null);
            }
        }

        return $this;
    }
}
