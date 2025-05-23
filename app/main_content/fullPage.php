<?php
session_start();
$loggedIn = isset($_SESSION['usuario_id']);
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlantaGotchi | Página Inicial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel = "stylesheet" type="text/css" href="../assets/style.css">
    </head>

  <body>
     <!-- sessão de cabeçalho do projeto -->
    <?php require "../components/header.php"; ?>
     <!-- sessão inicio -->
    <?php require "../pages/home.php"; ?>
    <!-- sessão O planta  NÃO ALTERADA ESTRUTURA-->
    <?php require "../pages/the_planta.php"; ?>
    <!-- sessão quem somos -->
    <?php require "../pages/about_us.php"; ?>
    <!-- sessão Galeria -->
    <?php require "../pages/galery.php"; ?>
    <!-- sessão Compre já-->
    <?php require "../pages/buy_now.php"; ?>
    <!-- sessão Entre em Contato -->
    <?php require "../pages/contact_us.php"; ?>
    <!-- sessão Entre em Rodape -->
    <?php require "../components/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>