<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerFormType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    #[Route('/answer', name: 'app_answer')]
    public function index(): Response
    {
        return $this->render('answer/index.html.twig', [
            'controller_name' => 'AnswerController',
        ]);
    }

    #[Route ('/question/create/{id}/answer/create', name:'create_answer')]
    public function create_answer(Request $request, EntityManagerInterface $entityManager,$id,QuestionRepository $questionRepository): Response 
    {
        $question = $questionRepository->find($id);
        $answer = new Answer();

        $form = $this->createForm(AnswerFormType::class, $answer);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if ($question) {
                $answer->setQuestion($question);
            }

            $entityManager->persist($answer);
            $entityManager->flush();
            return $this->redirectToRoute('questions');
        }
        return $this->render('answer/add.html.twig', [
            'answerForm' => $form->createView(),
        ]);

    }
}
