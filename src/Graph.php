<?php

namespace App;

use App\Exceptions\InvalidEdgeException;

class Graph implements \JsonSerializable
{
    private array $edges;

    private array $matrix = [];

    private array $vertexes = [];

    /**
     * Adiciona uma aresta ao grafo
     * @param Edge $edge Aresta a ser adicionada
     * @return void
     */
    public function addEdge(Edge $edge): void
    {
        $this->edges[] = $edge;
    }

    /**
     * Retorna todas as arestas do grafo
     * @return array
     */
    public function getEdges(): array
    {
        return $this->edges;
    }

    /**
     * Serializa o grafo em JSON estruturado com as arestas, vértices e pesos, caso o grafo seja ponderado
     * @return string
     */
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