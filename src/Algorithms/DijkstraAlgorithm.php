<?php

namespace App\Algorithms;

use App\Graph;

class DijkstraAlgorithm
{
    private array $shortestPath = [];

    /**
     * @throws \Exception
     */
    public function shortestPath(Graph $graph, int $start, int $end)
    {
        $graphAdjacencyMatrix = $graph->getAdjacencyMatrix();
        $originVertexAdjacency = $graphAdjacencyMatrix[$start] ?? null;
        $destinyVertexAdjacency = $graphAdjacencyMatrix[$end] ?? null;

        if (empty($originVertexAdjacency)) {
            throw new \Exception('O vértice de origem não existe');
        }

        if (empty($destinyVertexAdjacency)) {
            throw new \Exception('O vértice de destino não existe');
        }

        $labeledGraph = false;
        $vertex = $start;
        while (!$labeledGraph) {
            $vertexAdjacencyMatrix = $graphAdjacencyMatrix[$vertex];

            foreach ($vertexAdjacencyMatrix as $vertexForValidation => $isAdjacent) {
                $visited[$vertex][$vertex] = [
                    'weight' => 0,
                    'previous' => null,
                ];

                if ($isAdjacent) {
                    $edge = $graph->getEdge($vertex, $vertexForValidation);

                    if ($vertex == $vertexForValidation) {
                        continue;
                    }

                    $visited[$vertex][$vertexForValidation] = [
                        'weight' => $edge->getWeight() ?? 0,
                        'previous' => $vertex,
                    ];
                }
            }

            $labeledGraph = true;
        }

        dd($visited);
    }

    /**
     * Retorna a aresta com o menor peso
     *
     * @param array $adjacency Array de adjacência
     * @return mixed|null
     */
    public function getEdgeWithMinWeight(array $adjacency)
    {
        $minWeight = null;
        $minWeightEdge = null;

        foreach ($adjacency as $vertex => $edge) {
            if ($edge['weight'] < $minWeight || is_null($minWeight)) {
                $minWeight = $edge['weight'];
                $minWeightEdge = $edge;
            }
        }

        return $minWeightEdge;
    }

    /**
     * Verifica se a busca por um caminho mais curto chegou numa bifurcação
     * @param array $adjacency
     * @return bool
     */
    public function isBifurcation(array $adjacency): bool
    {
        $minWeight = null;
        $minWeightEdge = null;

        foreach ($adjacency as $vertex => $edge) {
            if ($edge['weight'] < $minWeight || is_null($minWeight)) {
                $minWeight = $edge['weight'];
                $minWeightEdge = $edge;
            }

            if ($edge['weight'] == $minWeight) {
                return true;
            }
        }

        return false;
    }
}