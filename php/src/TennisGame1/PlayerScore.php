<?php

namespace TennisGame1;

use InvalidArgumentException;

final class PlayerScore
{
    /**
     * @var int
     */
    private $value;

    public const WINNING_ADVANTAGE = 2;
    public const WINNING_POINT_MINIMUM = 4;
    /**
     * @var string
     */
    private $name;

    public function __construct(int $value, string $name)
    {
        $this->value = $value;
        $this->name = $name;
    }

    /**
     * @param self[] $players
     * @return PlayerScore
     */
    public static function max(array $players): self
    {
        return array_reduce($players, function (self $a, self $b) {
            if ($a->value > $b->value) {
                return $a;
            }

            return $b;
        }, new self(0, 'Nobody'));
    }

    /**
     * @param self[] $scores
     * @return bool
     */
    public static function allSameValue(array $scores): bool
    {
        assert(count($scores) > 1, new InvalidArgumentException('You must provide at least one score'));

        $previous = array_shift($scores);
        foreach ($scores as $score) {
            if ($score->value !== $previous->value) {
                return false;
            }
        }

        return true;
    }

    public function increase(): void
    {
        ++$this->value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function even(): string
    {
        switch ($this->value) {
            case 0:
                return "Love-All";
            case 1:
                return "Fifteen-All";
            case 2:
                return "Thirty-All";
            default:
                return "Deuce";
        }
    }

    public function textual(): string
    {
        switch ($this->value) {
            case 0:
                return "Love";
            case 1:
                return "Fifteen";
            case 2:
                return "Thirty";
            case 3:
                return "Forty";
            default:
                return '';
        }
    }
}
