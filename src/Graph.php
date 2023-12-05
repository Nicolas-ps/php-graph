<?php

namespace App;

class Graph implements \JsonSerializable
{
    private array $edges;
    
    public function addEdge(Edge $edge): void
    {
        $this->edges[] = $edge;
    }

    public function getEdges(): array
    {
        return $this->edges;
    }

    public function jsonSerialize(): string
    {
        $edges = [];
        foreach ($this->edges as $edge) {
            $edges[] = [
                'vertexA' => [
                    'value' => intval($edge->getVertexA()->getValue()),
                    'edges' => $edge->getVertexB()->getEdges()
                ],
                'vertexB' => [
                    'value' => intval($edge->getVertexB()->getValue()),
                    'edges' => $edge->getVertexB()->getEdges()
                ],
                'weight' => $edge->getWeight()
            ];
        }

        return json_encode($edges);
    }
}