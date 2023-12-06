<?php

namespace App;

class Edge
{
    private Vertex $vertexA;

    private Vertex $vertexB;

    private $weight;

    private string $hash;

    public function __construct(Vertex $vertexA, Vertex $vertexB, $weight = null)
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

    public function hasWeight(): bool
    {
        return ! is_null($this->weight);
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
            'weight' => $this->weight,
            'vertexA' => $this->vertexA->getValue(),
            'vertexB' => $this->vertexB->getValue(),
        ];
    }

    /**
     * Gera um hash único para a aresta
     * @param int $origin
     * @param int $end
     * @return string
     */
    public static function generateEdgeHash(int $origin, int $end): string
    {
        return base64_encode('edge_hash' . $origin . $end . $end . $origin);
    }
}