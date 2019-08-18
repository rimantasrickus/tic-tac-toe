<?php

namespace App\Controller;

use App\Entity\NPC;
use App\Entity\GameBoard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameBoardController extends AbstractController
{
    const DRAW = 'draw';

    /**
     * @Route("/game")
     */
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('game/game.html.twig', []);
    }

    /**
     * @Route("/move")
     */
    public function move(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $board = $data['board'];
        $level = $data['level'];

        // no winner yet
        if (!GameBoard::hasWon($board)) {
            // a draw
            if (!GameBoard::hasEmptyCells($board)) {
                return $this->makeResponse($board, self::DRAW);
            } else {
                $board = NPC::move($board, $level);
            }
        }

        // returns winner or '' if there's no winner
        return $this->makeResponse($board, GameBoard::getWinner($board));
    }

    private function makeResponse(array $board, string $winner): JsonResponse
    {
        return new JsonResponse([
            'winner' => $winner,
            'board' => $board
        ]);
    }
}
