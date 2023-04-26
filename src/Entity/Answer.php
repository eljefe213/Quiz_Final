<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Answer = null;

    #[ORM\Column]
    private ?bool $Is_True = null;

    #[ORM\ManyToOne(inversedBy: 'Answer')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $Question = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->Answer;
    }

    public function setAnswer(string $Answer): self
    {
        $this->Answer = $Answer;

        return $this;
    }

    public function isIsTrue(): ?bool
    {
        return $this->Is_True;
    }

    public function setIsTrue(bool $Is_True): self
    {
        $this->Is_True = $Is_True;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->Question;
    }

    public function setQuestion(?Question $Question): self
    {
        $this->Question = $Question;

        return $this;
    }

}
