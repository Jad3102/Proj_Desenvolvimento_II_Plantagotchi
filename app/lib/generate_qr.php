<?php
require_once __DIR__ . '/phpqrcode/qrlib.php';

// Texto vindo por GET
if (!isset($_GET['text'])) {
    die('Texto não definido');
}

$text = urldecode($_GET['text']);

// Gera imagem diretamente como resposta
QRcode::png($text);