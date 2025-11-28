<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Empréstimo</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/global.js"></script>
</head>
<body class="fundoAzul">
    <aside>
        <button id="opennavBar">
            <i class="fa-solid fa-angles-left" id="abrirMenu"></i>
            <i class="fa-solid fa-angles-right" id="fecharMenu" style="display: none;"></i>
        </button>
        <nav id="navBar">
            <div class="infosUser-menu flexRow">
                <i class="fa-regular fa-user"></i>
                <div class="flexColumn">
                    <p class="bolder"><?php echo htmlspecialchars($_SESSION['nome']);?></p>
                </div>
            </div>
            <ul class="navBar-list">
                <li>
                    <a href="./inicio.php" class="navBar-itemList">
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
            <a class="logout flexRow" type="button" href="./logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p>Logout</p>
            </a>
        </nav>
    </aside>

    <main id="content">
        <div class="container">
            <div class="flexColumn">
                <h1>Novo Empréstimo</h1>
                <hr>
                <form action="../php/processa_emprestimo.php" method="POST" class="flexColumn">
                    <label for="id_livro">ID do Livro</label>
                    <input type="number" name="id_livro" class="input welcome" required>

                    <label for="id_aluno">ID do Aluno</label>
                    <input type="number" name="id_aluno" class="input welcome" required>

                    <label for="data_retirada">Data da Retirada</label>
                    <input type="date" name="data_retirada" class="input welcome" required>

                    <label for="data_devolucao">Data da Devolução</label>
                    <input type="date" name="data_devolucao" class="input welcome">

                    <br>
                    <button type="submit" class="btn login">Registrar Empréstimo</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
