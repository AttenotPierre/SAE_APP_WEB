<?php

namespace classes\video;

class Catalogue
{
    private array $series = [];

    public function addSeries(Series $series): void
    {
        $this->series[] = $series;
    }
    public function __get($name)
    {
        return $this->$name;
    }
}