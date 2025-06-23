<?php
session_start();              // Inicia a sessão (necessário para destruí-la)
session_unset();              // Remove todas as variáveis de sessão
session_destroy();            // Destroi a sessão
// Redireciona para a página principal
header("Location:../main_content/fullPage.php");
exit();  