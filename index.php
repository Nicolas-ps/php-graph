<?php

ini_set('display_errors', true);
ini_set('display_startup_errors', true);
ini_set('error_reporting', E_ALL);

use App\Edge;
use App\Graph;
use App\Vertex;

require_once 'vendor/autoload.php';

$graph = new Graph();

$vertex1 = new Vertex(1);
$vertex2 = new Vertex(2);
$edge = new Edge($vertex1, $vertex2);

$vertex3 = new Vertex(3);
$edge2 = new Edge($vertex1, $vertex3);

$graph->addEdge($edge);
$graph->addEdge($edge2);

dd($graph);
