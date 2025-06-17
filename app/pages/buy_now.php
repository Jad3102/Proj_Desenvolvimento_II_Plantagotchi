<section id="buy_now" class="buy_now py-5 container-fluid text-center">
    <div class="row">
        <img src="../assets/images/planta-logo.svg" alt="logo do planta com flores em volta" class="img-fluid plantagotchi-logo">
        <?php if ($loggedIn): ?> 
            <a class="btn btn-buy_now" href="../pages/purchase.php" role="button">Compre já</a>
        <?php else: ?>
            <a class="btn btn-buy_now" href="../pages/login.php?redirect=purchase.php" role="button">Compre já</a>
        <?php endif; ?>
    </div>
</section>