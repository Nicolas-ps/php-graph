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

    /**
     * Constrói a matriz de adjacência do grafo
     * @return void
     */
    public function buildMatrix(): void
    {
        foreach ($this->edges as $edge) {
            $vertexA = $edge->getVertexA();
            $vertexB = $edge->getVertexB();

            $vertexAEdges = $edge->getVertexA()->getEdges();
            $vertexBEdges = $edge->getVertexB()->getEdges();

            $this->processesVertexAdjacency($vertexAEdges, $vertexA);
            $this->processesVertexAdjacency($vertexBEdges, $vertexB);

            $this->matrix[$vertexA->getValue()][$vertexB->getValue()] = true;
            $this->matrix[$vertexB->getValue()][$vertexA->getValue()] = true;
        }

        foreach ($this->vertexes as $vertex) {
            foreach ($this->vertexes as $vertex2) {
                if (! isset($this->matrix[$vertex][$vertex2])) {
                    $this->matrix[$vertex][$vertex2] = false;
                }

                if ($vertex == $vertex2) {
                    $this->matrix[$vertex][$vertex2] = true;
                }
            }
        }
    }

    public function getAdjacencyMatrix(): array
    {
        return $this->matrix;
    }

    /**
     * @throws InvalidEdgeException
     */
    public function addMultipleEdges(array $edges): void
    {
        foreach ($edges as $edge) {
            if (! $edge instanceof Edge) {
                throw new InvalidEdgeException('O array deve conter apenas objetos do tipo Edge');
            }

            $this->addEdge($edge);
        }
    }

    /**
     * Processa a adjacência de um vértice a partir de suas arestas
     * @param array $vertexEdges
     * @param Vertex $vertex
     * @return void
     */
    private function processesVertexAdjacency(array $vertexEdges, Vertex $vertex): void
    {
        foreach ($vertexEdges as $edge) {
            $this->vertexes[] = $edge['vertexA'];
            $this->vertexes[] = $edge['vertexB'];

            if ($edge['vertexA'] == $vertex->getValue()) {
                $this->matrix[$vertex->getValue()][$edge['vertexB']] = true;
            } else if ($edge['vertexB'] == $vertex->getValue()) {
                $this->matrix[$vertex->getValue()][$edge['vertexA']] = true;
            }
        }
    }
}