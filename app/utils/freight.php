<?php
function obterFretePorEstado($estado) {
    $valoresFrete = [
        'AC' => 45.00,
        'AL' => 30.00,
        'AP' => 50.00,
        'AM' => 55.00,
        'BA' => 25.00,
        'CE' => 22.00,
        'DF' => 20.00,
        'ES' => 18.00,
        'GO' => 20.00,
        'MA' => 27.00,
        'MT' => 28.00,
        'MS' => 26.00,
        'MG' => 15.00,
        'PA' => 35.00,
        'PB' => 25.00,
        'PR' => 17.00,
        'PE' => 24.00,
        'PI' => 23.00,
        'RJ' => 12.00,
        'RN' => 26.00,
        'RS' => 18.00,
        'RO' => 40.00,
        'RR' => 50.00,
        'SC' => 16.00,
        'SP' => 10.00,
        'SE' => 22.00,
        'TO' => 30.00
    ];

    return $valoresFrete[$estado] ?? 30.00; // valor padrão se não encontrado
}
?>
