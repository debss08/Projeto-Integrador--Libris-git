<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libris - Início</title>
    <link rel="stylesheet" href="../style/css/global.css">
    <link rel="stylesheet" href="../style/css/public.css">
</head>
<body>

    <header class="public-header">
        <a href="index.php" class="logo">
            <img src="../style/imgs/logoLibris.svg" alt="">
        </a>
        <nav class="public-nav">
            <a href="index.php">Início</a>
            <a href="acervo.php">Acervo</a>
            <a href="area_aluno.php">Meus empréstimos</a>
            <a href="login_aluno.php" class="btn-login">Login</a>
            <a href="cadastro_aluno.php" class="btn-cadastrar">Cadastrar</a>
        </nav>
    </header>

    <main>
        <section class="hero-section">
            <div class="hero-content">
                <h1>Expand your mind, reading a book</h1>
                <p>Pouco texto, pouco texto, pouco texto, pouco texto, pouco texto, pouco texto, pouco texto, pouco texto, pouco texto...</p>
            </div>
            <div class="hero-image">
                <img src="../style/imgs/livrosGrandesFlutuantes.png" alt="">
                </div>
        </section>
        <div class="hero-bottom-curve"></div>

        <section class="actions-section">
            <h2>O que quer fazer agora?</h2>
            <div class="actions-grid">
                <div class="action-card">
                    <img src="../style/imgs/trioLivrosPequenos.png" alt="">
                    <h3>Ver acervo</h3>
                    <a href="acervo.php" class="btn login">Acessar →</a>
                </div>
                <div class="action-card">
                    <img src="../style/imgs/trioLivrosPequenos.png" alt="">
                    <h3>Meus empréstimos</h3>
                    <a href="area_aluno.php" class="btn login">Acessar →</a>
                </div>
                <div class="action-card">
                    <img src="../style/imgs/trioLivrosPequenos.png" alt="">
                    <h3>Painel administrativo</h3>
                    <a href="login_admin.html" class="btn login">Acessar →</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="public-footer">
        <a href="index.php" class="logo">✦ libris</a>
        <p>Copyright © IFSul 2025 | Desenvolvido por Débora de Oliveira e Vitória Pless</p>
        <nav class="footer-nav">
            <a href="acervo.php">Acervo</a>
            <a href="area_aluno.php">Meus empréstimos</a>
            <a href="login_admin.html">Painel administrativo</a>
        </nav>
    </footer>

</body>
</html>