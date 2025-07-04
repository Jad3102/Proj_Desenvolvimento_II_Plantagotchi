<?php
// Define caminho dinâmico para links do menu
$fullPagePath = '/main_content/fullPage.php';
?>
<header class="container-fluid shadow-sm main-header">
    <nav class="navbar px-5 px-md-5 d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a class="navbar-brand" href="../main_content/fullPage.php">
            <img src="app/assets/images/planta_logo.png" alt="Logo do Site" width="30">
        </a>

        <ul class="nav">
        <li class="nav-item"><a class="nav-link" href="<?= $fullPagePath ?>">Início</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $fullPagePath ?>#the_planta">Produto</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $fullPagePath ?>#about_us">Quem Somos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $fullPagePath ?>#galery">Galeria</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $fullPagePath ?>#buy_now">Comprar</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $fullPagePath ?>#contact">Contato</a></li>

            <!-- Sessão ativa quando usuário está logado -->
            <?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_nome'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle position-relative" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!
                        <span id="badge-header" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                            0
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="../pages/my_account.php">Minha Conta</a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="../pages/my_orders.php">
                            Meus Pedidos
                            <span id="badge-menu" class="badge bg-danger rounded-pill d-none">0</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="../pages/logout.php">Sair</a>
                        </li>
                    </ul>
                </li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="../pages/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Script para buscar notificações -->
    <?php if (isset($_SESSION['usuario_id'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('../db/notification_count.php')
                .then(res => res.json())
                .then(data => {
                    const count = data.count || 0;
                    const badgeHeader = document.getElementById('badge-header');
                    const badgeMenu = document.getElementById('badge-menu');

                    if (count > 0) {
                        if (badgeHeader) {
                            badgeHeader.classList.remove('d-none');
                            badgeHeader.textContent = count;
                        }
                        if (badgeMenu) {
                            badgeMenu.classList.remove('d-none');
                            badgeMenu.textContent = count;
                        }
                    }
                })
                .catch(err => console.error('Erro ao carregar notificações:', err));
        });
    </script>
    <?php endif; ?>
</header>
