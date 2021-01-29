<?php

declare(strict_types=1);

namespace App;

final class Matcher
{
    private MatcherStrategy $matcherStrategy;

    public function __construct(MatcherStrategy $matcherStrategy)
    {
        $this->matcherStrategy = $matcherStrategy;
    }

    public function match(): void
    {
        $this->matcherStrategy->match();
    }
}