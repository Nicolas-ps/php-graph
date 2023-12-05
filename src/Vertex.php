<?php

namespace App;

class Vertex
{
    private array $edges = [];
    
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getEdges(): array
    {
        $edges = [];

        foreach ($this->edges as $edge) {
            $edges[] = $edge;
        }

        return $edges;
    }

    public function addToEdge(Edge $edge): void
    {
        $this->edges[] = $edge->get();
    }
}