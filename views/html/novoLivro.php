<?php
session_start();
if (!isset($_SESSION['admin_id'])) { 
    header("Location: ./login_admin.html"); // Ajustado
    exit();
}
// Caminhos ajustados para a nova estrutura
require_once "../../php/models/Conexao.php"; 
require_once "../../php/models/Categoria.php";
$categorias = Categoria::listarTodas();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Cadastrar novo livro</title>
    <link rel="stylesheet" href="../../css/global.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../../js/global.js"></script> <style>
        .modal { ... } 
        .modal-content { ... }
        .btn-add-categoria { ... }
    </style>
</head>
<body class="fundoAzul">
    <aside>
        <nav id="navBar">
            <ul class="navBar-list">
                <li><a href="./inicio.php" class="navBar-itemList">...</a></li>
                <li><a href="./emprestimos.php" class="navBar-itemList">...</a></li>
                <li><a href="./biblio.php" class="navBar-itemList">...</a></li>
            </ul>
            <a class="logout flexRow" type="button" href="../../php/util/logout.php">...</a> </nav>
    </aside>
    <main id="content">
        <div class="item-book flexColumn">
            <div class="flexColumn">
                <h1>Novo livro</h1>
                <hr>
                <form action="../../php/controllers/ProcessaLivro.php" method="POST" enctype="multipart/form-data" class="flexColumn">
                    <div class="categoria-label">
                        <label for="categoria">Categoria</label>
                        <button type="button" class="btn-add-categoria" id="btnAbrirModal">+</button>
                    </div>
                    <select id="categoria" name="categoria" class="input welcome" required>
                        </select>
                    <br>
                    <button type="submit" class="btn login">Registrar livro</button>
                </form>
            </div>
        </div>
    </main>

    <div id="modalCategoria" class="modal"> ... </div>

    <script>
    $(document).ready(function() {
        // ... (seu código JS do modal) ...
        formCategoria.on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                url: '../../php/controllers/ProcessaCategoria.php', // Caminho ajustado
                type: 'POST',
                // ... (resto do seu AJAX) ...
            });
        });
    });
    </script>
</body>
</html>