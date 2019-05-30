<?php

use TennisGame1\PlayerScore;

class TennisGame1 implements TennisGame
{
    private $m_score1 = 0;
    private $m_score2 = 0;
    private $player1Name = '';
    private $player2Name = '';

    /**
     * @var PlayerScore[]
     */
    private $scores;

    public function __construct($player1Name, $player2Name)
    {
        $this->player1Name = $player1Name;
        $this->player2Name = $player2Name;
        $this->scores = [
            $player1Name => new PlayerScore(0, $player1Name),
            $player2Name => new PlayerScore(0, $player2Name),
        ];
    }

    public function wonPoint($playerName)
    {
        $this->scores[$playerName]->increase();

        if ($this->player1Name == $playerName) {
            $this->m_score1++;
        } else {
            $this->m_score2++;
        }
    }

    public function getScore()
    {
        if (PlayerScore::allSameValue($this->scores)) {
            $score = $this->scores[$this->player1Name]->even();
        } elseif ($this->m_score1 >= PlayerScore::WINNING_POINT_MINIMUM || $this->m_score2 >= PlayerScore::WINNING_POINT_MINIMUM) {
            $max = PlayerScore::max($this->scores);
            $minusResult = $this->m_score1 - $this->m_score2;
            if (abs($minusResult) == 1) {
                $score = "Advantage {$max->name()}";
            } else {
                $score = "Win for {$max->name()}";
            }
        } else {
            $scoreParts = array_map(function (PlayerScore $score) {
                return $score->textual();
            }, $this->scores);

            $score = implode('-', $scoreParts);
        }
        return $score;
    }
}

