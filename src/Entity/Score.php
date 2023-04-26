<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoreRepository::class)]
class Score
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Score = null;

    #[ORM\OneToOne(mappedBy: 'Score_id', cascade: ['persist', 'remove'])]
    private ?Game $Game = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->Score;
    }

    public function setScore(int $Score): self
    {
        $this->Score = $Score;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->Game;
    }

    public function setGame(Game $Game): self
    {
        // set the owning side of the relation if necessary
        if ($Game->getScoreId() !== $this) {
            $Game->setScoreId($this);
        }

        $this->Game = $Game;

        return $this;
    }
}
