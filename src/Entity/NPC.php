<?php

namespace App\Entity;

class NPC
{
    const EASY_CPU = 'easy';
    const MEDIUM_CPU = 'medium';
    const HARD_CPU = 'hard';

    public static function move(array $board, string $level = 'easy'): array
    {
        switch ($level) {
            case self::EASY_CPU:
                $position = self::getPositionEasy($board);
                $board[$position]['value'] = 'o';
                break;
            case self::MEDIUM_CPU:
                $position = self::getPositionMedium($board);
                $board[$position]['value'] = 'o';
                break;
            case self::HARD_CPU:
                $position = self::getPositionHard($board);
                $board[$position]['value'] = 'o';
                break;
        }
        
        return $board;
    }

    /**
     * Get random available position
     *
     * @param array $board
     *
     * @return int
     */
    public static function getPositionEasy(array $board): int
    {
        $position = rand(0, 8);
        while ($board[$position]['value'] !== '') {
            $position = rand(0, 8);
        }

        return $position;
    }

    /**
     * Look for two in a row and block else return random position
     *
     * @param array $board
     *
     * @return int
     */
    public static function getPositionMedium(array $board, string $value = 'x'): int
    {
        // Row 1
        if ($board[0]['value'] === $value && $board[0]['value'] === $board[1]['value'] && $board[2]['value'] === '') {
            return 2;
        }
        if ($board[0]['value'] === $value && $board[0]['value'] === $board[2]['value'] && $board[1]['value'] === '') {
            return 1;
        }
        if ($board[1]['value'] === $value && $board[1]['value'] === $board[2]['value'] && $board[0]['value'] === '') {
            return 0;
        }

        // Row 2
        if ($board[3]['value'] === $value && $board[3]['value'] === $board[4]['value'] && $board[5]['value'] === '') {
            return 5;
        }
        if ($board[3]['value'] === $value && $board[3]['value'] === $board[5]['value'] && $board[4]['value'] === '') {
            return 4;
        }
        if ($board[4]['value'] === $value && $board[4]['value'] === $board[5]['value'] && $board[3]['value'] === '') {
            return 3;
        }

        // Row 3
        if ($board[6]['value'] === $value && $board[6]['value'] === $board[7]['value'] && $board[8]['value'] === '') {
            return 8;
        }
        if ($board[6]['value'] === $value && $board[6]['value'] === $board[8]['value'] && $board[7]['value'] === '') {
            return 7;
        }
        if ($board[7]['value'] === $value && $board[4]['value'] === $board[8]['value'] && $board[6]['value'] === '') {
            return 6;
        }

        // Column 1
        if ($board[0]['value'] === $value && $board[0]['value'] === $board[3]['value'] && $board[6]['value'] === '') {
            return 6;
        }
        if ($board[0]['value'] === $value && $board[0]['value'] === $board[6]['value'] && $board[3]['value'] === '') {
            return 3;
        }
        if ($board[3]['value'] === $value && $board[3]['value'] === $board[6]['value'] && $board[0]['value'] === '') {
            return 0;
        }

        // Column 2
        if ($board[1]['value'] === $value && $board[1]['value'] === $board[4]['value'] && $board[7]['value'] === '') {
            return 7;
        }
        if ($board[1]['value'] === $value && $board[1]['value'] === $board[7]['value'] && $board[4]['value'] === '') {
            return 4;
        }
        if ($board[4]['value'] === $value && $board[4]['value'] === $board[7]['value'] && $board[1]['value'] === '') {
            return 1;
        }

        // Column 3
        if ($board[2]['value'] === $value && $board[2]['value'] === $board[5]['value'] && $board[8]['value'] === '') {
            return 8;
        }
        if ($board[2]['value'] === $value && $board[2]['value'] === $board[8]['value'] && $board[5]['value'] === '') {
            return 5;
        }
        if ($board[5]['value'] === $value && $board[5]['value'] === $board[8]['value'] && $board[2]['value'] === '') {
            return 2;
        }

        // Across 1
        if ($board[0]['value'] === $value && $board[0]['value'] === $board[4]['value'] && $board[8]['value'] === '') {
            return 8;
        }
        if ($board[0]['value'] === $value && $board[0]['value'] === $board[8]['value'] && $board[4]['value'] === '') {
            return 4;
        }
        if ($board[4]['value'] === $value && $board[4]['value'] === $board[8]['value'] && $board[0]['value'] === '') {
            return 0;
        }
        
        // Across 2
        if ($board[2]['value'] === $value && $board[2]['value'] === $board[4]['value'] && $board[6]['value'] === '') {
            return 6;
        }
        if ($board[2]['value'] === $value && $board[2]['value'] === $board[6]['value'] && $board[4]['value'] === '') {
            return 4;
        }
        if ($board[4]['value'] === $value && $board[4]['value'] === $board[6]['value'] && $board[2]['value'] === '') {
            return 2;
        }

        return self::getPositionEasy($board);
    }

    /**
     * Advanced logic based on player's moves
     *
     * @param array $board
     *
     * @return int
     */
    public static function getPositionHard(array $board): int
    {
        // if first move
        if (self::countXs($board) === 1) {
            // and middle
            if ($board[4]['value'] === 'x') {
                //block corner
                return self::getRandomPosition([0, 2, 6, 8]);
            }

            // middle is empty, take it
            return 4;
        }

        // if second move
        if (self::countXs($board) === 2) {
            $myFirstPosition = self::getMyFirstPosition($board);
            // middle occupied
            if ($board[4]['value'] === 'x') {
                // is second move corner
                if ($board[0]['value'] === 'x' && $board[0]['value'] === $board[4]['value']) {
                    if ($myFirstPosition === 6 || $myFirstPosition === 2) {
                        return 8;
                    }
                    if ($myFirstPosition === 8) {
                        return self::getRandomPosition([2, 6]);
                    }
                }
                if ($board[2]['value'] === 'x' && $board[2]['value'] === $board[4]['value']) {
                    if ($myFirstPosition === 0 || $myFirstPosition === 8) {
                        return 6;
                    }
                    if ($myFirstPosition === 6) {
                        return self::getRandomPosition([0, 8]);
                    }
                }
                if ($board[6]['value'] === 'x' && $board[6]['value'] === $board[4]['value']) {
                    if ($myFirstPosition === 0 || $myFirstPosition === 8) {
                        return 2;
                    }
                    if ($myFirstPosition === 2) {
                        return self::getRandomPosition([0, 8]);
                    }
                }
                if ($board[8]['value'] === 'x' && $board[8]['value'] === $board[4]['value']) {
                    if ($myFirstPosition === 6 || $myFirstPosition === 2) {
                        return 0;
                    }
                    if ($myFirstPosition === 0) {
                        return self::getRandomPosition([2, 6]);
                    }
                }

                // if second move not corner, block
                return self::getPositionMedium($board);
            }

            // we have middle
            if (($board[0]['value'] === 'x' && $board[0]['value'] === $board[8]['value'])
                || ($board[2]['value'] === 'x' && $board[2]['value'] === $board[6]['value'])
            ) {
                // take a line
                return self::getRandomPosition([1, 3, 5, 7]);
            }
        }

        // if third move
        if (self::countXs($board) === 3) {
            if (self::canWin($board)) {
                return self::winningPosition($board);
            }
        }

        // block two Xs
        return self::getPositionMedium($board);
    }

    private static function getMyFirstPosition(array $board): int
    {
        return self::getMyAllPositions($board)[0];
    }

    private static function getMyAllPositions(array $board): array
    {
        $positions = array();
        foreach ($board as $key => $cell) {
            if ($cell['value'] === 'o') {
                $positions[] = $key;
            }
        }

        return $positions;
    }

    private static function canWin(array $board): bool
    {
        if (self::countOs($board) === 2) {
            $myPositions = self::getMyAllPositions($board);

            // if we have middle
            if (in_array(4, $myPositions)) {
                // remove middle from positions array
                if (($key = array_search(4, $myPositions)) !== false) {
                    unset($myPositions[$key]);
                    // reindex array
                    $myPositions = array_values($myPositions);
                }

                if ($myPositions[0] === 0 && $board[8]['value'] === '') {
                    return true;
                }
                if ($myPositions[0] === 1 && $board[7]['value'] === '') {
                    return true;
                }
                if ($myPositions[0] === 2 && $board[6]['value'] === '') {
                    return true;
                }
                if ($myPositions[0] === 3 && $board[5]['value'] === '') {
                    return true;
                }
                if ($myPositions[0] === 5 && $board[3]['value'] === '') {
                    return true;
                }
                if ($myPositions[0] === 6 && $board[2]['value'] === '') {
                    return true;
                }
                if ($myPositions[0] === 7 && $board[1]['value'] === '') {
                    return true;
                }
                if ($myPositions[0] === 8 && $board[0]['value'] === '') {
                    return true;
                }
            }

            // we don't have middle
            // row 1
            if ($board[0]['value'] === 'o' && $board[0]['value'] === $board[1]['value'] && $board[2]['value'] === '') {
                return true;
            }
            if ($board[0]['value'] === 'o' && $board[0]['value'] === $board[2]['value'] && $board[1]['value'] === '') {
                return true;
            }
            if ($board[1]['value'] === 'o' && $board[1]['value'] === $board[2]['value'] && $board[0]['value'] === '') {
                return true;
            }
            // col 1
            if ($board[0]['value'] === 'o' && $board[0]['value'] === $board[3]['value'] && $board[6]['value'] === '') {
                return true;
            }
            if ($board[0]['value'] === 'o' && $board[0]['value'] === $board[6]['value'] && $board[3]['value'] === '') {
                return true;
            }
            if ($board[3]['value'] === 'o' && $board[3]['value'] === $board[6]['value'] && $board[0]['value'] === '') {
                return true;
            }
            // row 3
            if ($board[6]['value'] === 'o' && $board[6]['value'] === $board[7]['value'] && $board[8]['value'] === '') {
                return true;
            }
            if ($board[6]['value'] === 'o' && $board[6]['value'] === $board[8]['value'] && $board[7]['value'] === '') {
                return true;
            }
            if ($board[7]['value'] === 'o' && $board[7]['value'] === $board[8]['value'] && $board[6]['value'] === '') {
                return true;
            }
            // col 3
            if ($board[2]['value'] === 'o' && $board[2]['value'] === $board[5]['value'] && $board[8]['value'] === '') {
                return true;
            }
            if ($board[2]['value'] === 'o' && $board[2]['value'] === $board[8]['value'] && $board[5]['value'] === '') {
                return true;
            }
            if ($board[5]['value'] === 'o' && $board[5]['value'] === $board[8]['value'] && $board[2]['value'] === '') {
                return true;
            }
        }

        return false;
    }

    private static function countOs(array $board): int
    {
        return count(self::getMyAllPositions($board));
    }

    private static function countXs(array $board): int
    {
        $count = 0;
        foreach ($board as $cell) {
            if ($cell['value'] === 'x') {
                $count++;
            }
        }

        return $count;
    }

    private static function winningPosition(array $board): int
    {
        // instead of looking for two Xs to block, look for two Os to win
        return self::getPositionMedium($board, 'o');
    }

    private function getRandomPosition(array $possibleMoves): int
    {
        $key = array_rand($possibleMoves, 1);

        return $possibleMoves[$key];
    }
}
