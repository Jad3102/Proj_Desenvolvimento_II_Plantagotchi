<?php
require_once __DIR__ . '/../db/connection_db.php';

function buscarPedidos(PDO $conn, array $filtros = []): array {
    $where = [];
    $params = [];

    if (!empty($filtros['nome'])) {
        $where[] = 'u.nome LIKE ?';
        $params[] = '%' . $filtros['nome'] . '%';
    }
    if (!empty($filtros['cor'])) {
        $where[] = 'p.cor = ?';
        $params[] = $filtros['cor'];
    }
    if (!empty($filtros['quantidade'])) {
        $where[] = 'p.quantidade = ?';
        $params[] = $filtros['quantidade'];
    }
    if (!empty($filtros['valor_min'])) {
        $where[] = 'p.preco_total >= ?';
        $params[] = number_format($filtros['valor_min'], 2, '.', '');
    }
    if (!empty($filtros['valor_max'])) {
        $where[] = 'p.preco_total <= ?';
        $params[] = number_format($filtros['valor_max'], 2, '.', '');
    }
    if (!empty($filtros['status'])) {
        $where[] = 'p.status = ?';
        $params[] = $filtros['status'];
    }
    if (!empty($filtros['data_ini'])) {
        $where[] = 'p.criado_em >= ?';
        $params[] = $filtros['data_ini'] . ' 00:00:00';
    }
    if (!empty($filtros['data_fim'])) {
        $where[] = 'p.criado_em <= ?';
        $params[] = $filtros['data_fim'] . ' 23:59:59';
    }

    $sql = "SELECT p.*, u.nome AS nome_usuario, pr.nome AS nome_produto 
            FROM pedidos p 
            JOIN usuarios u ON p.usuario_id = u.usuario_id 
            JOIN produtos pr ON p.produto_id = pr.produto_id";

    if ($where) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }

    $sql .= ' ORDER BY p.criado_em DESC';

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function calcularMetricas(PDO $conn): array {
    $sql = "SELECT status, preco_total FROM pedidos";
    $stmt = $conn->query($sql);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalReceber = 0;
    $totalRecebido = 0;
    $pagos = 0;
    $preparacao = 0;
    $enviados = 0;
    $pendentes = 0;

    foreach ($pedidos as $pedido) {
        if ($pedido['status'] === 'Pago') {
            $totalReceber += $pedido['preco_total'];
            $totalRecebido += $pedido['preco_total'];
            $pagos++;
        } elseif ($pedido['status'] === 'Aguardando pagamento') {
            $totalReceber += $pedido['preco_total'];
            $pendentes++;
        } elseif ($pedido['status'] === 'Em preparação') {
            $preparacao++;
        } elseif ($pedido['status'] === 'Enviado') {
            $enviados++;
        }
    }

    return [
        'total_a_receber' => $totalReceber,
        'total_recebido' => $totalRecebido,
        'pedidos_pagos' => $pagos,
        'pedidos_em_preparacao' => $preparacao,
        'pedidos_enviados' => $enviados,
        'pedidos_aguardando_pagamento' => $pendentes,
    ];
}

function calcularSLA(string $status, string $criadoEm): string {
    if ($status !== 'Aguardando pagamento') return '';
    $dataAtual = new DateTime();
    $criado = new DateTime($criadoEm);
    $intervalo = $criado->diff($dataAtual);
    return $intervalo->format('%ad %hh %im');
}