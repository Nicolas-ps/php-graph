<?php

namespace App\Algorithms;

use App\Graph;
use Exception;

class DijkstraAlgorithm
{
    private array $shortestPath = [];

    /**
     * @throws Exception
     */
    public function getShortestPath(Graph $graph, int $start, int $end): array
    {
        $this->shortestPath($graph, $start, $end);

        return $this->shortestPath;
    }

    /**
     * @throws Exception
     */
    private function shortestPath(Graph $graph, int $origin, int $destination): void
    {
        $distances = array_fill(0, count($graph->getVertexes()), INF);
        $previous = [];
        $matrix = $graph->getAdjacencyMatrix();
        $visited = $graph->getVertexes();

        $distances[$origin] = 0;

        while (count($visited) > 0) {
            $minDistanceVertex = $this->getEdgeWithMinWeight($matrix, $visited);
            if ($minDistanceVertex == null) {
                break;
            }

            if ($minDistanceVertex == $destination) {
                break;
            }

            foreach ($matrix[$minDistanceVertex] as $neighbor => $weight) {
                $alt = $distances[$minDistanceVertex] != INF ? $distances[$minDistanceVertex] + $weight : $weight;
                if ($alt < $distances[$neighbor]) {
                    $distances[$neighbor] = $alt;
                    $previous[$neighbor] = $minDistanceVertex;
                }
            }

            unset($visited[$minDistanceVertex]);
        }

        dd($distances, $previous);
    }

    /**
     * Retorna a aresta com o menor peso
     *
     * @param array $matrix Array de adjacência
     * @return int|null
     */
    public function getEdgeWithMinWeight(array $matrix, array $visited): ?int
    {
        $min = INF;
        $minDistanceVertex = null;

        foreach ($visited as $vertex) {
            foreach ($matrix[$vertex] as $adjacentVertex => $weight) {
                if ($weight === 0) continue;

                if ($weight < $min && $vertex != $adjacentVertex && ! empty($visited[$adjacentVertex])) {
                    $min = $weight;
                    $minDistanceVertex = $adjacentVertex;
                }
            }
        }

        return $minDistanceVertex;
    }
}