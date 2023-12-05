<?php

namespace App;

class Edge
{
    private Vertex $vertexA;

    private Vertex $vertexB;

    private int $weight;

    public function __construct(Vertex $vertexA, Vertex $vertexB, $weight = 1)
    {
        $this->vertexA = $vertexA;
        $this->vertexB = $vertexB;
        $this->weight = $weight;

        $this->vertexA->addToEdge($this);
        $this->vertexB->addToEdge($this);
    }

    public function getEnds(): array
    {
        return [$this->vertexA, $this->vertexB];
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getVertexA(): Vertex
    {
        return $this->vertexA;
    }

    public function getVertexB(): Vertex
    {
        return $this->vertexB;
    }

    public function get(): array
    {
        return [
            'hash' => base64_encode(uniqid($this->vertexA->getValue() . $this->vertexB->getValue())),
            'weight' => $this->weight,
            'vertexA' => $this->vertexA->getValue(),
            'vertexB' => $this->vertexB->getValue(),
        ];
    }
}