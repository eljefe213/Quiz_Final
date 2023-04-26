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

    #[ORM\ManyToMany(targetEntity: Question::class, inversedBy: 'Games')]
    private Collection $Question_id;

    public function __construct()
    {
        $this->Question_id = new ArrayCollection();
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
     * @return Collection<int, Question>
     */
    public function getQuestionId(): Collection
    {
        return $this->Question_id;
    }

    public function addQuestionId(Question $questionId): self
    {
        if (!$this->Question_id->contains($questionId)) {
            $this->Question_id->add($questionId);
        }

        return $this;
    }

    public function removeQuestionId(Question $questionId): self
    {
        $this->Question_id->removeElement($questionId);

        return $this;
    }

}
