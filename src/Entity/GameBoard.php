<?php

namespace App\Entity;

class GameBoard
{
    public static function hasWon(array $board)
    {
        if (self::getWinner($board) !== '') {
            return true;
        }
        
        return false;
    }

    public static function getWinner(array $board): string
    {
        // Rows
        if ($board[0]['value'] !== '' && $board[0]['value'] === $board[1]['value'] && $board[0]['value'] === $board[2]['value']) {
            return $board[0]['value'];
        }
        if ($board[3]['value'] !== '' && $board[3]['value'] === $board[4]['value'] && $board[3]['value'] === $board[5]['value']) {
            return $board[3]['value'];
        }
        if ($board[6]['value'] !== '' && $board[6]['value'] === $board[7]['value'] && $board[6]['value'] === $board[8]['value']) {
            return $board[6]['value'];
        }

        // Columns
        if ($board[0]['value'] !== '' && $board[0]['value'] === $board[3]['value'] && $board[0]['value'] === $board[6]['value']) {
            return $board[0]['value'];
        }
        if ($board[1]['value'] !== '' && $board[1]['value'] === $board[4]['value'] && $board[1]['value'] === $board[7]['value']) {
            return $board[1]['value'];
        }
        if ($board[2]['value'] !== '' && $board[2]['value'] === $board[5]['value'] && $board[2]['value'] === $board[8]['value']) {
            return $board[2]['value'];
        }

        // Across
        if ($board[0]['value'] !== '' && $board[0]['value'] === $board[4]['value'] && $board[0]['value'] === $board[8]['value']) {
            return $board[0]['value'];
        }
        if ($board[2]['value'] !== '' && $board[2]['value'] === $board[4]['value'] && $board[2]['value'] === $board[6]['value']) {
            return $board[2]['value'];
        }

        return '';
    }

    public static function hasEmptyCells(array $board)
    {
        $emptyCell = 9;
        foreach ($board as $cell) {
            if ($cell['value'] !== '') {
                $emptyCell -= 1;
            }
        }

        if ($emptyCell > 0) {
            return true;
        }

        return false;
    }
}
