<?php

ini_set('display_errors', true);
ini_set('display_startup_errors', true);
ini_set('error_reporting', E_ALL);

use App\Edge;
use App\Exceptions\InvalidEdgeException;
use App\Graph;
use App\Vertex;

require_once 'vendor/autoload.php';

$graph = new Graph();

$vertex1 = new Vertex(1);
$vertex2 = new Vertex(2);
$vertex3 = new Vertex(3);
$vertex4 = new Vertex(4);
$vertex5 = new Vertex(5);
$vertex6 = new Vertex(6);

$edge = new Edge($vertex1, $vertex2);
$edge2 = new Edge($vertex1, $vertex3);
$edge3 = new Edge($vertex1, $vertex4);
$edge4 = new Edge($vertex3, $vertex4);
$edge5 = new Edge($vertex2, $vertex3);
$edge6 = new Edge($vertex2, $vertex4);
$edge7 = new Edge($vertex4, $vertex5);
$edge8 = new Edge($vertex5, $vertex6);

try {
    $graph->addMultipleEdges([
        $edge,
        $edge2,
        $edge3,
        $edge4,
        $edge5,
        $edge7,
        $edge8
    ]);
} catch (InvalidEdgeException $e) {
    dd("Erro ao adicionar arestas ao grafo: {$e->getMessage()}");
}

$graph->buildMatrix();
dd($graph->getAdjacencyMatrix());
