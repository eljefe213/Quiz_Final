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
    private Collection $Answer;

    #[ORM\OneToMany(mappedBy: 'Question', targetEntity: GameQuestion::class)]
    private Collection $gameQuestions;

    public function __construct()
    {
        $this->Answer = new ArrayCollection();
        $this->gameQuestions = new ArrayCollection();
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
    public function getAnswer(): Collection
    {
        return $this->Answer;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->Answer->contains($answer)) {
            $this->Answer->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->Answer->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

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
            $this->gameQuestions->add($gameQuestion);
            $gameQuestion->setQuestion($this);
        }

        return $this;
    }

    public function removeGameQuestion(GameQuestion $gameQuestion): self
    {
        if ($this->gameQuestions->removeElement($gameQuestion)) {
            // set the owning side to null (unless already changed)
            if ($gameQuestion->getQuestion() === $this) {
                $gameQuestion->setQuestion(null);
            }
        }

        return $this;
    }
}
