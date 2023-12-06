<?php

namespace App\Algorithms;

use App\Graph;

class DijkstraAlgorithm
{
    private array $visited = [];

    private array $shortestPath = [];

    /**
     * @throws \Exception
     */
    public function shortestPath(Graph $graph, int $start, int $end)
    {
        $this->shortestPath[] = $start;
        $graphAdjacencyMatrix = $graph->getAdjacencyMatrix();
        $originVertexAdjacency = $graphAdjacencyMatrix[$start] ?? null;
        $destinyVertexAdjacency = $graphAdjacencyMatrix[$end] ?? null;

        if (empty($originVertexAdjacency)) {
            throw new \Exception('O vértice de origem não existe');
        }

        if (empty($destinyVertexAdjacency)) {
            throw new \Exception('O vértice de destino não existe');
        }

        $vertex = $start;
        $vertexAdjacencyMatrix = $graphAdjacencyMatrix[$vertex];

        foreach ($vertexAdjacencyMatrix as $vertexForValidation => $isAdjacent) {
            if (isset($this->visited[$vertex][$vertexForValidation])) {
                continue;
            }

            $this->visited[$vertex][$vertex] = [
                'weight' => 0,
                'previous' => null,
            ];

            if ($isAdjacent) {
                $edge = $graph->getEdge($vertex, $vertexForValidation);

                if ($vertex == $vertexForValidation) {
                    continue;
                }

                $this->visited[$vertex][$vertexForValidation] = [
                    'weight' => $edge->getWeight() ?? 0,
                    'previous' => $vertex,
                ];
            }

            $this->shortestPath($graph, $vertexForValidation, $end);
        }
    }

    /**
     * Retorna a aresta com o menor peso
     *
     * @param array $adjacency Array de adjacência
     * @return int|string|null
     */
    public function getEdgeWithMinWeight(array $adjacency)
    {
        $minWeight = null;
        $nextVertex = null;

        foreach ($adjacency as $vertex => $weightAndPrevious) {
            if (! $weightAndPrevious['previous']) {
                continue;
            }

            if ($weightAndPrevious['weight'] < $minWeight || is_null($minWeight)) {
                $minWeight = $weightAndPrevious['weight'];
                $nextVertex = $vertex;
            }
        }

        return $nextVertex;
    }

    /**
     * Verifica se a busca por um caminho mais curto chegou numa bifurcação
     * @param array $adjacency
     * @return bool
     */
    public function isBifurcation(array $adjacency): bool
    {
        $minWeight = null;

        foreach ($adjacency as $vertex => $edge) {
            if (! $edge['previous']) {
                continue;
            }

            if ($edge['weight'] == $minWeight && ! is_null($minWeight)) {
                return true;
            }

            if ($edge['weight'] < $minWeight || is_null($minWeight)) {
                $minWeight = $edge['weight'];
            }
        }

        return false;
    }
}