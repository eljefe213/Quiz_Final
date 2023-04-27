<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Game;
use App\Entity\Score;
use App\Repository\AnswerRepository;
use App\Repository\GameRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game_create')]
    public function create_game(QuestionRepository $questionRepository, Request $request, EntityManagerInterface $entityManager,): Response
    {
        $questions = $questionRepository->findAll();
        $questions_length = count($questions);

        // Mélange des questions
        shuffle($questions);

        // Sélection des 3 premières questions
        $questions = array_slice($questions, 0, 3);

        // récupérer l'utilisateur connecté
        $user = $this->getUser();
        // créer une nouvelle instance de l'objet Game
        $game = new Game();

        $game->setUser($user);

        $score = new Score();
        $score->setGame($game);
        $score->setScore(0);

        // ajouter chaque question sélectionnée à l'objet Game
        foreach ($questions as $question) {
            $game->addQuestionId($question);
        }

        // enregistrer l'objet Game en base de données
        $entityManager->persist($game);
        $entityManager->flush();

        // récupérer l'ID de l'objet Game
        $gameId = $game->getId();


        // rediriger l'utilisateur vers la page de jeu
        return $this->redirectToRoute('app_game', ['id' => $gameId], Response::HTTP_SEE_OTHER);
    }

    #[Route('/game/{id}', name: 'app_game')]
    public function index(QuestionRepository $questionRepository, $id, GameRepository $gameRepository): Response
    {

        $game = $gameRepository->find($id);
        //dd($game);


        return $this->render('game/index.html.twig', [
            'game' => $game,
        ]);
    }
}
