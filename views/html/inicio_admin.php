<?php
session_start();

if ($_SESSION['nivel'] != 'admin' || !isset($_SESSION['admin_id'])) {
    header("Location: ./index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração | Libris</title>
    <link rel="stylesheet" href="../style/css/global.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/global.js"></script>
</head>
<body class="fundoAzul">
    <aside>
        <nav id="navBar">
            <div class="infosUser-menu flexRow">
                <i class="fa-solid fa-user-gear"></i>
                <p class="bolder">Admin: <?php echo htmlspecialchars($_SESSION['nome']);?></p>
            </div>
            <ul class="navBar-list">
                <li>
                    <a href="./inicio_admin.php" class="navBar-itemList">
                        <i class="fa-solid fa-house"></i>
                        <p>Início</p>
                    </a>
                </li>
                <li>
                    <a href="./emprestimos.php" class="navBar-itemList">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <p>Empréstimos</p>
                    </a>
                </li>
                <li>
                    <a href="./biblio.php" class="navBar-itemList">
                        <i class="fa-solid fa-book"></i>
                        <p>Acervo</p>
                    </a>
                </li>
            </ul>
            <a class="logout flexRow" type="button" href="../../php/util/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p>Logout</p>
            </a>
        </nav>
    </aside>
    <main id="content">
        <div class="container textWelcome">
            <div class="flexColumn">
                <h1 class="tituloPrincipal">Bem vindo(a), Administrador(a) <?php echo htmlspecialchars($_SESSION['nome']);?>!</h1>
                <p class="descricao">Você está na área de Gerenciamento <b>Administrativo</b> do Libris.</p>
            </div>
            <img src="../style/imgs/bibliotecariaBranca.png" alt="jdfj">
        </div>

        <div class="invisibleContainer">
            <h1 class="flexCenter">Ações do Administrador</h1>
            
            <div class="mainActions-container">
                <div class="mainAction roxo">
                    <a href="./novoLivro.php" class="icon-mainAction">
                        <i class="fa-solid fa-book-open"></i>
                    </a>
                    <h2>Cadastrar novo livro</h2>
                    <a href="./novoLivro.php">
                        <button type="button" class="btn btn-mainAction">
                            Acessar
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </a>
                </div>
                <div class="mainAction rosa">
                    <a href="./novaEmprestimo.php" class="icon-mainAction">
                        <i class="fa-solid fa-tags"></i>
                    </a>
                    <h2>Fazer novo empréstimo</h2>
                    <a href="./novaEmprestimo.php">
                        <button type="button" class="btn btn-mainAction">
                            Acessar
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <footer class="footer">
            Webmasters: Débora Martins de Oliveira e Vitória da Costa Pless
        </footer>
    </main>
    
</body>