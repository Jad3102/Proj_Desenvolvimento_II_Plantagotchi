<header class="container-fluid shadow-sm admin-header">    
    <nav class="navbar px-5 px-md-5 d-flex justify-content-between align-items-center">
        
        <!-- Logo -->
        <a class="navbar-brand" href="../main_content/fullPage.php">
            <img src="../assets/images/planta_logo.png" alt="Logo do Site" width="30">
        </a>

        <ul class="nav">
            <?php if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_nome'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Olá, <?= htmlspecialchars($_SESSION['admin_nome']) ?>!
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item text-danger" href="../pages/logout.php">Sair</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </nav> 
</header>