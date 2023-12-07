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

    }

    /**
     * Retorna a aresta com o menor peso
     *
     * @param array $adjacency Array de adjacência
     * @return int|string|null
     */
    public function getEdgeWithMinWeight(array $adjacency, int $start)
    {

    }

    private function reconstructPath(array $previous, int $start, int $end): array
    {

    }
}