<?php

namespace App;

use App\Exceptions\InvalidEdgeException;

class Graph implements \JsonSerializable
{
    private array $edges = [];

    private array $matrix = [];

    private array $vertexes = [];

    private bool $weighted;

     public function __construct(bool $weighted = false)
    {
        $this->weighted = $weighted;
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
     * Retorna uma aresta do grafo a partir de dois vértices
     * @param int $origin
     * @param int $end
     * @return Edge|null
     */
    public function getEdge(int $origin, int $end): ?Edge
    {
        $edgeOfVertex = null;
        foreach ($this->edges as $edge) {
            $pointsAreEndsCheckOne = $edge->get()['vertexA'] == $origin && $edge->get()['vertexB'] == $end;
            $pointsAreEndsCheckTwo = $edge->get()['vertexA'] == $end && $edge->get()['vertexB'] == $origin;

            if ($pointsAreEndsCheckOne || $pointsAreEndsCheckTwo) {
                $edgeOfVertex = $edge;
                break;
            }
        }

        return $edgeOfVertex;
    }


    /**
     * Adiciona uma aresta ao grafo
     * @param Edge $edge Aresta a ser adicionada
     * @return void
     * @throws InvalidEdgeException
     */
    public function addEdge(Edge $edge): void
    {
        if ($this->weighted && ! $edge->hasWeight()) {
            throw new InvalidEdgeException('O grafo é ponderado, portanto a aresta deve ter um peso');
        }

        $this->edges[] = $edge;
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

            if ($this->weighted && ! $edge->hasWeight()) {
                throw new InvalidEdgeException('O grafo é ponderado, portanto todas as arestas devem ter um peso');
            }

            $this->addEdge($edge);
        }
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

            $this->matrix[$vertexA->getValue()][$vertexB->getValue()] = $this->weighted ? $edge->getWeight() : 1;
            $this->matrix[$vertexB->getValue()][$vertexA->getValue()] = $this->weighted ? $edge->getWeight() : 1;
        }

        foreach ($this->vertexes as $vertex) {
            foreach ($this->vertexes as $vertex2) {
                if (! isset($this->matrix[$vertex][$vertex2])) {
                    $this->matrix[$vertex][$vertex2] = 0;
                }

                if ($vertex == $vertex2) {
                    $this->matrix[$vertex][$vertex2] = 1;
                }
            }
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
            // @todo implementar validação para não adicionar vértices repetidos
            if (! in_array($edge['vertexA'], $this->vertexes)) {
                $this->vertexes[] = $edge['vertexA'];
            }

            if (! in_array($edge['vertexB'], $this->vertexes)) {
                $this->vertexes[] = $edge['vertexB'];
            }

            if ($edge['vertexA'] == $vertex->getValue()) {
                $this->matrix[$vertex->getValue()][$edge['vertexB']] = $this->weighted ? $edge['weight'] : 1;
            } else if ($edge['vertexB'] == $vertex->getValue()) {
                $this->matrix[$vertex->getValue()][$edge['vertexA']] = $this->weighted ? $edge['weight'] : 1;
            }
        }
    }

    public function getAdjacencyMatrix(): array
    {
        return $this->matrix;
    }

    public function getVertexes(): array
    {
        return $this->vertexes;
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