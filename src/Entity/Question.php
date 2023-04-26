<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Question = null;

    #[ORM\ManyToOne(inversedBy: 'Question_Id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;



    #[ORM\OneToMany(mappedBy: 'Question', targetEntity: Answer::class)]
    private Collection $Answer_Id;

    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'Question_id')]
    private Collection $Games;

    public function __construct()
    {
        $this->Answer_Id = new ArrayCollection();
        $this->Games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->Question;
    }

    public function setQuestion(string $Question): self
    {
        $this->Question = $Question;

        return $this;
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



    /**
     * @return Collection<int, Answer>
     */
    public function getAnswerId(): Collection
    {
        return $this->Answer_Id;
    }

    public function addAnswerId(Answer $answerId): self
    {
        if (!$this->Answer_Id->contains($answerId)) {
            $this->Answer_Id->add($answerId);
            $answerId->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswerId(Answer $answerId): self
    {
        if ($this->Answer_Id->removeElement($answerId)) {
            // set the owning side to null (unless already changed)
            if ($answerId->getQuestion() === $this) {
                $answerId->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->Games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->Games->contains($game)) {
            $this->Games->add($game);
            $game->addQuestionId($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->Games->removeElement($game)) {
            $game->removeQuestionId($this);
        }

        return $this;
    }
}
