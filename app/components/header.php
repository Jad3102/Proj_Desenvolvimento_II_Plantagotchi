<header class="container-fluid shadow-sm main-header">
    <nav class="navbar px-5 px-md-5 d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a class="navbar-brand" href="../main_content/fullPage.php">
            <img src="../assets/images/planta_logo.png" alt="Logo do Site" width="30">
        </a>

        <!-- Navegação -->
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="../main_content/fullPage.php">Início</a></li>
            <li class="nav-item"><a class="nav-link" href="#the_planta">Produto</a></li>
            <li class="nav-item"><a class="nav-link" href="#about_us">Quem Somos</a></li>
            <li class="nav-item"><a class="nav-link" href="#galery">Galeria</a></li>
            <li class="nav-item"><a class="nav-link" href="#buy_now">Comprar</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact">Contato</a></li>
            <!-- Com sessão de login ativo, exibidos o nome do usuário no canto superior direito durante navegação -->
            <?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nome'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!
                    </a>
                    <!-- Inserção de opção "Minha Conta" para acesso aos produtos e "Sair" para finalizar sessão " -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="../pages/my_account.php">Minha Conta</a></li>
                        <li><a class="dropdown-item" href="../pages/my_orders.php">Meus Pedidos</a></li>
                        <li><a class="dropdown-item text-danger" href="../pages/logout.php">Sair</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="../pages/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>