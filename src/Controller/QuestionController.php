<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionFormType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/questions', name: 'questions')]
    public function index(QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->findAll();

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    #[Route ('/question/create', name:'create_question')]
    public function create_question(Request $request, EntityManagerInterface $entityManager): Response 
    {
        $question = new Question();

        $form = $this->createForm(QuestionFormType::class, $question);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                $question->setUser($this->getUser());
            }

            $entityManager->persist($question);
            $entityManager->flush();
            return $this->redirectToRoute('questions');
        }
        return $this->render('question/add.html.twig', [
            'questionForm' => $form->createView(),
        ]);

    }

}