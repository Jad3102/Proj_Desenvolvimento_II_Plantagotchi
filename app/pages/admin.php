<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel = "stylesheet" type="text/css" href="../assets/style.css">
</head>

<body class="admin_content">

    <?php require "../components/header_admin.php"; ?>

    <div class="quadro_geral d-flex justify-content-center flex-wrap gap-3">
        
        <div class="item individual_square">
            <h3>Total a receber</h3>
            <p>Resposta do banco</p>
        </div>
        <div class="item individual_square">
            <h3>Pedidos pagos</h3>
            <p>Resposta do banco</p>
        </div>
        <div class="item individual_square">
            <h3>Pedidos em Trânsito</h3>
            <p>Resposta do banco</p>
        </div>
        <div class="item individual_square">
            <h3>Pedidos Completos</h3>
            <p>Resposta do banco</p>
        </div>
        <div class="item individual_square">
            <h3>Total recebido</h3>
            <p>Resposta do banco</p>
        </div>
       
    </div>

   <div class="container tabela-container">
    <div class="titulo">
     <h3>Pedidos</h3>
    </div>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="acoes">✔️</th>
          <th>ID</th>
          <th>Rastreamento</th>
          <th>Status de Pagamento</th>
          <th>Destinatário</th>
          <th>Dúvidas</th>
        </tr>
      </thead>
      <tbody>
        <!-- Exemplo de linha -->
        <tr>
          <td class="acoes">
            <i class="bi bi-pencil"></i>
            <i class="bi bi-check-square"></i>
            <i class="bi bi-trash"></i>
          </td>
          <td>001</td>
          <td>TRK123</td>
          <td>Pago</td>
          <td>João</td>
          <td>---</td>
        </tr>
        <!-- Repita linhas conforme necessário -->
          <tr>
          <td class="acoes">
            <i class="bi bi-pencil"></i>
            <i class="bi bi-check-square"></i>
            <i class="bi bi-trash"></i>
          </td>
          <td>001</td>
          <td>TRK123</td>
          <td>Pago</td>
          <td>João</td>
          <td>---</td>
        </tr>
         <tr>
          <td class="acoes">
            <i class="bi bi-pencil"></i>
            <i class="bi bi-check-square"></i>
            <i class="bi bi-trash"></i>
          </td>
          <td>001</td>
          <td>TRK123</td>
          <td>Pago</td>
          <td>João</td>
          <td>---</td>
        </tr>
         <tr>
          <td class="acoes">
            <i class="bi bi-pencil"></i>
            <i class="bi bi-check-square"></i>
            <i class="bi bi-trash"></i>
          </td>
          <td>001</td>
          <td>TRK123</td>
          <td>Pago</td>
          <td>João</td>
          <td>---</td>
        </tr>
         <tr>
          <td class="acoes">
            <i class="bi bi-pencil"></i>
            <i class="bi bi-check-square"></i>
            <i class="bi bi-trash"></i>
          </td>
          <td>001</td>
          <td>TRK123</td>
          <td>Pago</td>
          <td>João</td>
          <td>---</td>
        </tr>
      </tbody>
    </table>
  </div>
    
    
    <?php require "../components/footer.php"; ?>
</body>
</html>