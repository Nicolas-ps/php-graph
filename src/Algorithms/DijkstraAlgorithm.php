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
        $distancia = array_fill(0, count($graph->getVertexes()), INF);
        $previous = array_fill(1, count($graph->getVertexes()), null);

        $distancia[$origin - 1] = 0;
        $visitados = [];

        while (count($visitados) != count($distancia)) {
            $verticeAtual = null;
            $menorDistancia = INF;

            for ($i = 0; $i < count($graph->getVertexes()); $i++) {
                if (! in_array($i, $visitados) && $distancia[$i] < $menorDistancia) {
                    $verticeAtual = $i;
                    $menorDistancia = $distancia[$i];
                }
            }

            $visitados[] = $verticeAtual;
            foreach ($graph->getAdjacencyMatrix()[$verticeAtual + 1] as $vizinho => $peso) {
                if ($distancia[$verticeAtual] + $peso < $distancia[$vizinho - 1] && $peso != 0) {
                    $distancia[$vizinho - 1] = $distancia[$verticeAtual] + $peso;
                    $previous[$vizinho] = $verticeAtual + 1;
                }
            }
        }

        $path = [];
        $current = $destination;
        while (!is_null($current)) {
            array_unshift($path, $current);
            $current = $previous[$current];
        }

        $this->shortestPath = $path;
    }
}