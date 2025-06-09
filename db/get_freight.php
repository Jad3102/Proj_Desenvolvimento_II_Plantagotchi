<?php
require_once __DIR__ . '/../utils/freight.php';

header('Content-Type: application/json');

$uf = $_GET['uf'] ?? '';
$valor = obterFretePorEstado($uf);

echo json_encode(['valor' => $valor]);
